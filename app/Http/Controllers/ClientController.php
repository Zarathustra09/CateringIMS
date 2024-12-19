<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role_id', 2)->get();
        return view('admin.client.index', compact('clients'));
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
}
