<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role_id', 0)->get();
    
        // Load reservations and payments for each client
        $payments = collect();
    
        foreach ($clients as $client) {
            foreach ($client->reservations as $reservation) {
                if ($reservation->payment) {
                    $payment = $reservation->payment;
                    $payment->reservation = $reservation;
                    $payment->client_id = $client->id;
                    $payments->push($payment);
                }
            }
        }
    
        $groupedPayments = $payments->groupBy('client_id');
    
        return view('admin.client.index', compact('clients', 'groupedPayments'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate client ID
        $prefix = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5));
        $suffix = substr(str_shuffle('0123456789'), 0, 5);
        $client_id = $prefix . '-' . $suffix;

        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'employee_id' => $client_id,
        ]);

        return response()->json(['success' => 'Client created successfully']);
    }

    public function show($id)
    {
        $client = User::findOrFail($id);
        return response()->json($client);
    }

    public function update(Request $request, $id)
    {
        $client = User::findOrFail($id);
        $client->update($request->all());
        return response()->json(['success' => 'Client updated successfully']);
    }

    public function destroy($id)
    {
        $client = User::findOrFail($id);
        $client->delete();
        return response()->json(['success' => 'Client deleted successfully']);
    }

    public function getPayments(user $client)
{
    // Assuming the Client model has a payments relationship defined
    $payments = $client->payments;

    // Return a JSON response with the payment details
    return response()->json($payments);
}

    
}
