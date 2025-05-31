<?php

    namespace App\Http\Controllers;

    use Barryvdh\DomPDF\Facade\Pdf;
    use App\Mail\ReservationMail;
    use App\Models\ReservationMenu;
    use Illuminate\Http\Request;
    use App\Models\Payment;
    use App\Models\Reservation;
    use App\Models\Service;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Str;
    use Xendit\Configuration;
    use Xendit\Invoice\CreateInvoiceRequest;
    use Xendit\Invoice\InvoiceApi;

    class PaymentController extends Controller
    {
        public function index()
        {
            $userId = auth()->id();

            // Clear any lingering session data when viewing payment history
            $this->clearReservationSessionData();

            $payments = Payment::where('user_id', $userId)->get();
            $reservations = Reservation::where('user_id', $userId)->get();

            return view('guest.history.index', compact('payments', 'reservations'));
        }

        public function create()
        {
            // Only clear session if coming from a fresh reservation start
            // Don't clear if we're in the middle of a payment flow
            $fromPaymentProcess = session()->has('payment_in_progress');

            if (!$fromPaymentProcess) {
                $this->clearReservationSessionData();
            }

            $services = Service::all();
            return view('guest.reservation.create', compact('services'));
        }

        public function choosePaymentType()
        {
            // Get session data
            $serviceId = session('service_id');
            $service = Service::findOrFail($serviceId);
            $totalAmount = $service->price;

            // Determine payment amount based on payment type
            $paymentType = session('payment_type', 'full');
            $isDownPayment = $paymentType === 'downpayment';
            $amountToPay = $isDownPayment ? ($totalAmount * 0.5) : $totalAmount;

            return view('guest.payments.checkout', compact('service', 'totalAmount', 'amountToPay', 'isDownPayment'));
        }

        public function processCheckout(Request $request)
        {
            $request->validate([
                'payment_method' => 'required|in:cash,gcash,paymaya',
            ]);

            $paymentMethod = $request->input('payment_method');

            DB::beginTransaction();

            try {
                // Create the reservation
                $reservation = new Reservation();
                $reservation->user_id = Auth::id();
                $reservation->service_id = session('service_id');
                $reservation->category_event_id = session('category_event_id');
                $reservation->event_name = session('event_name');
                $reservation->start_date = session('start_date');
                $reservation->end_date = session('end_date');
                $reservation->message = session('message');
                $reservation->status = 'pending';
                $reservation->save();

                // Create menu relationships for the reservation
                $selectedMenus = session('selected_menus');
                foreach ($selectedMenus as $menuId) {
                    ReservationMenu::create([
                        'reservation_id' => $reservation->id,
                        'menu_id' => $menuId
                    ]);
                }

                // Get payment details
                $service = Service::findOrFail(session('service_id'));
                $totalAmount = $service->price;
                $paymentType = session('payment_type', 'full');
                $isDownPayment = $paymentType === 'downpayment';
                $amountToPay = $isDownPayment ? ($totalAmount * 0.5) : $totalAmount;

                // Generate a unique reference number
                $referenceNumber = 'PAY-' . strtoupper(Str::random(8));

                // Create payment record
                $payment = new Payment();
                $payment->user_id = Auth::id();
                $payment->reservation_id = $reservation->id;
                $payment->external_id = $referenceNumber;
                $payment->status = 'pending';
                $payment->total = $totalAmount;
                $payment->amount_paid = $amountToPay;
                $payment->is_down_payment = $isDownPayment;
                $payment->payment_type = $paymentMethod;
                $payment->save();

                // Send SMS notification for new reservation
                $user = Auth::user();
                $reservationDetails = [
                    'name' => $user->name,
                    'event_name' => $reservation->event_name,
                    'reference' => $referenceNumber,
                    'amount' => $amountToPay,
                    'payment_type' => $isDownPayment ? 'Down Payment' : 'Full Payment'
                ];

                // Only send SMS if user has a phone number
                if ($user->phone_number) {
                    $this->sendSmsNotification($user->phone_number, $reservationDetails);
                }

                DB::commit();

                // Clear session data after successful transaction
                $this->clearReservationSessionData();

                // For demonstration purposes, redirect to instructions page
                return redirect()->route('payment.instructions', [
                    'reference' => $referenceNumber,
                    'amount' => $amountToPay,
                    'method' => $paymentMethod
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in checkout process:', ['error' => $e->getMessage()]);
                return back()->withErrors(['error' => 'An error occurred during checkout. Please try again.']);
            }
        }

        /**
         * Clear reservation-related session data after successful transaction
         */
        private function clearReservationSessionData()
        {
            // List all session keys related to the reservation process
            $sessionKeys = [
                'service_id',
                'event_name',
                'category_event_id',
                'description',
                'start_date',
                'end_date',
                'message', // Added message to clear
                'selected_menus',
                'payment_type',
                'total'
            ];

            // Clear each session key
            foreach ($sessionKeys as $key) {
                session()->forget($key);
            }
        }

        public function showPaymentInstructions(Request $request)
        {
            $referenceNumber = $request->query('reference');
            $amountToPay = $request->query('amount');
            $paymentMethod = $request->query('method');

            // Make sure session data is cleared
            $this->clearReservationSessionData();

            return view('guest.payments.instructions', compact('referenceNumber', 'amountToPay', 'paymentMethod'));
        }

        public function payRemainingBalance($reservationId)
        {
            try {
                $reservation = Reservation::findOrFail($reservationId);
                $previousPayment = Payment::where('reservation_id', $reservationId)
                    ->where('is_down_payment', true)
                    ->first();

                if (!$previousPayment) {
                    return redirect()->route('guest.history.index')->with('error', 'No down payment found for this reservation.');
                }

                $remainingAmount = $previousPayment->total - $previousPayment->amount_paid;
                $service = Service::findOrFail($reservation->service_id);

                return view('guest.payments.checkout', [
                    'service' => $service,
                    'totalAmount' => $remainingAmount,
                    'amountToPay' => $remainingAmount,
                    'isDownPayment' => false,
                    'isBalancePayment' => true,
                    'reservationId' => $reservationId
                ]);
            } catch (\Exception $e) {
                Log::error('Error processing remaining balance payment:', ['error' => $e->getMessage()]);
                return redirect()->route('guest.history.index')->with('error', 'An error occurred while processing the payment. Please try again.');
            }
        }

        public function markAsPaidTestingMode(Request $request)
        {
            $request->validate([
                'reference_number' => 'required|string',
            ]);

            $referenceNumber = $request->input('reference_number');
            $payment = Payment::where('external_id', $referenceNumber)->first();

            if (!$payment) {
                return response()->json(['error' => 'Payment not found'], 404);
            }

            $reservation = Reservation::find($payment->reservation_id);

            // Mark payment as paid
            $payment->status = 'paid';
            $payment->save();

            // Update reservation status based on payment type
            if ($reservation) {
                $reservation->status = $payment->is_down_payment ? 'partially_paid' : 'confirmed';
                $reservation->save();
            }

            // Clear any remaining session data
            $this->clearReservationSessionData();

            return response()->json(['success' => true]);
        }

private function sendSmsNotification($phoneNumber, $reservationDetails)
       {
           try {
               $apiKey = env('SEMAPHORE_API_KEY');
               $sender = env('SEMAPHORE_SENDER_ID', 'SEMAPHORE');

               // Format message based on payment type - each limited to 110 characters
               if ($reservationDetails['payment_type'] === 'Balance Payment') {
                   $message = "Your balance payment of ₱{$reservationDetails['amount']} for {$reservationDetails['event_name']} received. Ref: {$reservationDetails['reference']}";
               } elseif ($reservationDetails['payment_type'] === 'Down Payment') {
                   $message = "Down payment of ₱{$reservationDetails['amount']} for {$reservationDetails['event_name']} received. Ref: {$reservationDetails['reference']}";
               } else { // Full Payment
                   $message = "Full payment of ₱{$reservationDetails['amount']} for {$reservationDetails['event_name']} received. Ref: {$reservationDetails['reference']}";
               }

               // Send SMS via Semaphore API
               $response = Http::post('https://api.semaphore.co/api/v4/messages', [
                   'apikey' => $apiKey,
                   'number' => $phoneNumber,
                   'message' => $message,
                   'sendername' => $sender
               ]);

               Log::info('SMS notification sent', [
                   'phone' => $phoneNumber,
                   'response' => $response->json()
               ]);

               return $response->successful();
           } catch (\Exception $e) {
               Log::error('Failed to send SMS notification', [
                   'error' => $e->getMessage()
               ]);
               return false;
           }
       }
        public function downloadPDF(Payment $payment)
        {
            // Clear any session data when downloading PDF
            $this->clearReservationSessionData();

            $reservation = $payment->reservation;

            $data = [
                'payment' => $payment,
                'reservation' => $reservation,
                'remaining_balance' => $payment->is_down_payment ? ($payment->total - $payment->amount_paid) : 0,
            ];

            $pdf = PDF::loadView('guest.history.pdf', $data);
            return $pdf->download('payment_receipt_' . $payment->id . '.pdf');
        }

        public function processBalancePayment(Request $request, $reservationId)
        {
            $request->validate([
                'payment_method' => 'required|in:cash,gcash,paymaya',
            ]);

            $reservation = Reservation::findOrFail($reservationId);
            $previousPayment = Payment::where('reservation_id', $reservationId)
                ->where('is_down_payment', true)
                ->first();

            if (!$previousPayment || $previousPayment->status !== 'paid') {
                return redirect()->route('guest.history.index')->with('error', 'Invalid payment status.');
            }

            $remainingAmount = $previousPayment->total - $previousPayment->amount_paid;
            $paymentMethod = $request->input('payment_method');

            DB::beginTransaction();

            try {
                // Generate a unique reference number
                $referenceNumber = 'BAL-' . strtoupper(Str::random(8));

                // Create payment record for the balance
                $balancePayment = new Payment();
                $balancePayment->user_id = Auth::id();
                $balancePayment->reservation_id = $reservation->id;
                $balancePayment->external_id = $referenceNumber;
                $balancePayment->status = 'pending';
                $balancePayment->total = $previousPayment->total;
                $balancePayment->amount_paid = $remainingAmount;
                $balancePayment->is_down_payment = false; // This is a balance payment
                $balancePayment->payment_type = $paymentMethod;
                $balancePayment->save();

                // Send SMS notification for balance payment
                $user = Auth::user();
                $reservationDetails = [
                    'name' => $user->name,
                    'event_name' => $reservation->event_name,
                    'reference' => $referenceNumber,
                    'amount' => $remainingAmount,
                    'payment_type' => 'Balance Payment'
                ];

                // Only send SMS if user has a phone number
                if ($user->phone_number) {
                    $this->sendSmsNotification($user->phone_number, $reservationDetails);
                }

                DB::commit();

                return redirect()->route('payment.instructions', [
                    'reference' => $referenceNumber,
                    'amount' => $remainingAmount,
                    'method' => $paymentMethod
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in balance payment process:', ['error' => $e->getMessage()]);
                return back()->withErrors(['error' => 'An error occurred during payment processing. Please try again.']);
            }
        }    }
