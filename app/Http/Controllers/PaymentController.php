<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function store(Request $request)
    {
        Log::info('Payment store function called with request data:', $request->all());

        $request->validate([
            'total' => 'required|numeric',
            'service' => 'required|string',
            'description' => 'required|string',
        ]);

        $service = Service::find($request->input('service'));

        if (!$service) {
            Log::error('Invalid service selected:', ['service' => $request->input('service')]);
            return back()->withErrors(['service' => 'Invalid service selected.']);
        }

        Configuration::setXenditKey(env('XENDIT_API_KEY'));
        $apiInstance = new InvoiceApi();

        $external_id = 'invoice-' . Str::random(5);
        $total = $request->input('total');
        $success_redirect_url = route('payment.success', ['external_id' => $external_id]);
        $failure_redirect_url = route('payment.failed');

        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => $external_id,
            'description' => $request->input('description'),
            'amount' => $total,
            'invoice_duration' => 172800,
            'currency' => 'PHP',
            'reminder_time' => 1,
            'success_redirect_url' => $success_redirect_url,
            'failure_redirect_url' => $failure_redirect_url
        ]);

        Log::info('Creating invoice with details:', [
            'external_id' => $external_id,
            'description' => $request->input('description'),
            'amount' => $total,
            'success_redirect_url' => $success_redirect_url,
            'failure_redirect_url' => $failure_redirect_url
        ]);

        DB::beginTransaction();

        try {
            $result = $apiInstance->createInvoice($create_invoice_request);

            Log::info('Invoice created successfully:', [
                'invoice_url' => $result['invoice_url'],
                'invoice_id' => $result['id']
            ]);

            $reservation = new Reservation([
                'user_id' => Auth::id(),
                'service_id' => $service->id,
                'event_name' => $request->input('description'),
                'event_type' => $request->input('description'),
                'start_date' => now(),
                'end_date' => now()->addDays(1),
                'message' => $request->input('description'),
                'status' => 'pending',
            ]);

            $reservation->save();
            Log::info('Reservation saved successfully:', ['reservation_id' => $reservation->id]);

            $payment = new Payment([
                'user_id' => auth()->id(),
                'reservation_id' => $reservation->id,
                'external_id' => $external_id,
                'checkout_link' => $result['invoice_url'],
                'total' => $total,
                'status' => 'pending',
            ]);

            $payment->save();
            Log::info('Payment saved successfully:', [
                'user_id' => auth()->id(),
                'external_id' => $external_id,
                'checkout_link' => $result['invoice_url'],
                'status' => 'pending'
            ]);

            DB::commit();

            return redirect($result['invoice_url']);

        } catch (\Xendit\XenditSdkException $e) {
            DB::rollBack();

            Log::error('Exception when calling InvoiceApi->createInvoice:', [
                'message' => $e->getMessage(),
                'full_error' => $e->getFullError()
            ]);

            return response()->json(['message' => 'Exception when calling InvoiceApi->createInvoice: ' . $e->getMessage(), 'full_error' => $e->getFullError()], 500);
        }
    }

    public function success(Request $request)
    {
        $request->validate([
            'external_id' => 'required|string',
        ]);

        $external_id = $request->input('external_id');
        $payment = Payment::where('external_id', $external_id)->first();
        $reservation = Reservation::find($payment->reservation_id);

        if ($payment) {
            $payment->status = 'paid';
            $payment->save();
        }

        if ($reservation) {
            $reservation->status = 'confirmed';
            $reservation->save();
        }

        return redirect()->route('payment.index')->with('success', 'Payment successful.');
    }

    public function failed()
    {
        return redirect()->route('payment.index')->with('error', 'Payment unsuccessful.');
    }
}
