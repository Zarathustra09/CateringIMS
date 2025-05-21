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

        $payments = Payment::where('user_id', $userId)->get();
        $reservations = Reservation::where('user_id', $userId)->get();

        return view('guest.history.index', compact('payments', 'reservations'));
    }

    public function create()
    {
        $services = Service::all();
        return view('guest.reservation.create', compact('services'));
    }

    public function choosePaymentType()
    {
        // Validate session data
        if (!session('total') || !session('service_id')) {
            return redirect()->route('reservation.index')->with('error', 'Missing reservation information.');
        }

        $total = session('total');
        $downPaymentAmount = $total * 0.50; // 50% down payment

        return view('guest.riderect', compact('total', 'downPaymentAmount'));
    }

    public function store(Request $request)
    {
        Log::info('Payment store function called with request data:', $request->all());

        $request->validate([
            'total' => 'required|numeric',
            'service' => 'required|string',
            'description' => 'required|string',
            'payment_type' => 'required|in:full,downpayment',
        ]);

        $service = Service::find($request->input('service'));
        if (!$service) {
            Log::error('Invalid service selected:', ['service' => $request->input('service')]);
            return back()->withErrors(['service' => 'Invalid service selected.']);
        }

        // Check for overlapping reservations
        $startDate = session('start_date');
        $endDate = session('end_date');
        $overlappingReservations = Reservation::where('service_id', $service->id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();

        if ($overlappingReservations) {
            Log::error('Overlapping reservation found');
            return back()->withErrors(['reservation' => 'There is an overlapping reservation for the selected dates.']);
        }

        $total = $request->input('total');
        $isDownPayment = $request->input('payment_type') === 'downpayment';
        $amountToPay = $total;

        // If it's a down payment, calculate 50% of the total
        if ($isDownPayment) {
            $amountToPay = $total * 0.5;
        }

        Configuration::setXenditKey(env('XENDIT_API_KEY'));
        $apiInstance = new InvoiceApi();

        $external_id = 'invoice-' . Str::random(5);
        $success_redirect_url = route('payment.success', ['external_id' => $external_id]);
        $failure_redirect_url = route('payment.failed');

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => $external_id,
            'description' => $request->input('description') . ($isDownPayment ? ' (Down Payment)' : ' (Full Payment)'),
            'amount' => $amountToPay,
            'invoice_duration' => 172800,
            'currency' => 'PHP',
            'reminder_time' => 1,
            'success_redirect_url' => $success_redirect_url,
            'failure_redirect_url' => $failure_redirect_url
        ]);

        DB::beginTransaction();

        try {
            $result = $apiInstance->createInvoice($create_invoice_request);

            // Create reservation
            $reservation = new Reservation([
                'user_id' => Auth::id(),
                'service_id' => $service->id,
                'event_name' => session('event_name'),
                'category_event_id' => session('category_event_id'),
                'start_date' => session('start_date'),
                'end_date' => session('end_date'),
                'message' => $request->input('description'),
                'status' => 'pending',
            ]);

            $reservation->save();

            // Save selected menus
            $selectedMenus = session('selected_menus');
            foreach ($selectedMenus as $menuId) {
                ReservationMenu::create([
                    'reservation_id' => $reservation->id,
                    'menu_id' => $menuId,
                ]);
            }

            // Create payment record
            $payment = new Payment([
                'user_id' => auth()->id(),
                'reservation_id' => $reservation->id,
                'external_id' => $external_id,
                'checkout_link' => $result['invoice_url'],
                'total' => $total,
                'amount_paid' => $amountToPay,
                'is_down_payment' => $isDownPayment,
                'status' => 'pending',
            ]);

            $payment->save();

            DB::commit();

            // Send email notification
            $reservationDetails = [
                'name' => Auth::user()->name,
                'event_name' => session('event_name'),
                'service' => $service->name,
                'total' => $total,
                'amount_paid' => $amountToPay,
                'is_down_payment' => $isDownPayment,
                'description' => $request->input('description')
            ];

            Mail::to(Auth::user()->email)->send(new ReservationMail($reservationDetails));

            return redirect($result['invoice_url']);

        } catch (\Xendit\XenditSdkException $e) {
            DB::rollBack();
            Log::error('Exception when calling InvoiceApi->createInvoice:', [
                'message' => $e->getMessage(),
                'full_error' => $e->getFullError()
            ]);

            return back()->withErrors(['payment' => 'Error processing payment. Please try again.']);
        }
    }

    public function success(Request $request)
    {
        $request->validate([
            'external_id' => 'required|string',
        ]);

        $external_id = $request->input('external_id');
        $payment = Payment::where('external_id', $external_id)->first();

        if (!$payment) {
            return redirect()->route('payment.index')->with('error', 'Payment not found.');
        }

        $reservation = Reservation::find($payment->reservation_id);

        $payment->status = 'paid';
        $payment->save();

        if ($reservation) {
            // Set status based on payment type
            $reservation->status = $payment->is_down_payment ? 'partially_paid' : 'confirmed';
            $reservation->save();
        }

        return redirect()->route('payment.index')->with('success', 'Payment successful.');
    }

    public function failed()
    {
        return redirect()->route('payment.index')->with('error', 'Payment unsuccessful.');
    }

    public function payRemainingBalance($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        $existingPayment = Payment::where('reservation_id', $reservation_id)
                                  ->where('status', 'paid')
                                  ->where('is_down_payment', true)
                                  ->first();

        if (!$existingPayment) {
            return redirect()->route('payment.index')->with('error', 'No down payment found for this reservation.');
        }

        $remainingBalance = $existingPayment->total - $existingPayment->amount_paid;

        if ($remainingBalance <= 0) {
            return redirect()->route('payment.index')->with('error', 'This reservation is already fully paid.');
        }

        Configuration::setXenditKey(env('XENDIT_API_KEY'));
        $apiInstance = new InvoiceApi();

        $external_id = 'invoice-balance-' . Str::random(5);
        $success_redirect_url = route('payment.balance.success', ['external_id' => $external_id]);
        $failure_redirect_url = route('payment.failed');

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => $external_id,
            'description' => 'Remaining balance for reservation #' . $reservation->id,
            'amount' => $remainingBalance,
            'invoice_duration' => 172800,
            'currency' => 'PHP',
            'reminder_time' => 1,
            'success_redirect_url' => $success_redirect_url,
            'failure_redirect_url' => $failure_redirect_url
        ]);

        try {
            $result = $apiInstance->createInvoice($create_invoice_request);

            // Create a new payment record for the balance
            $balancePayment = new Payment([
                'user_id' => auth()->id(),
                'reservation_id' => $reservation->id,
                'external_id' => $external_id,
                'checkout_link' => $result['invoice_url'],
                'total' => $existingPayment->total,
                'amount_paid' => $remainingBalance,
                'is_down_payment' => false,
                'status' => 'pending',
            ]);

            $balancePayment->save();

            return redirect($result['invoice_url']);

        } catch (\Xendit\XenditSdkException $e) {
            Log::error('Exception when creating balance invoice:', [
                'message' => $e->getMessage(),
                'full_error' => $e->getFullError()
            ]);

            return redirect()->route('payment.index')->with('error', 'Error processing payment. Please try again.');
        }
    }

    public function balanceSuccess(Request $request)
    {
        $request->validate([
            'external_id' => 'required|string',
        ]);

        $external_id = $request->input('external_id');
        $payment = Payment::where('external_id', $external_id)->first();

        if (!$payment) {
            return redirect()->route('payment.index')->with('error', 'Payment not found.');
        }

        $reservation = Reservation::find($payment->reservation_id);

        $payment->status = 'paid';
        $payment->save();

        // Update reservation status to confirmed since balance is now paid
        if ($reservation) {
            $reservation->status = 'confirmed';
            $reservation->save();
        }

        return redirect()->route('payment.index')->with('success', 'Balance payment successful. Your reservation is now fully confirmed.');
    }

    public function downloadPDF(Payment $payment)
    {
        $reservation = $payment->reservation;

        $data = [
            'payment' => $payment,
            'reservation' => $reservation,
            'remaining_balance' => $payment->is_down_payment ? ($payment->total - $payment->amount_paid) : 0,
        ];

        $pdf = PDF::loadView('guest.history.pdf', $data);
        return $pdf->download('payment_receipt_' . $payment->id . '.pdf');
    }
}
