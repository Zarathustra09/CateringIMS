<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PayPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $payPeriods = PayPeriod::all();
        $users = User::where('role_id', 1)->get();
        return view('admin.employee.index', compact('users', 'payPeriods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate employee ID
        $prefix = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5));
        $suffix = substr(str_shuffle('0123456789'), 0, 5);
        $employee_id = $prefix . '-' . $suffix;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role_id' => 1,
            'employee_id' => $employee_id,
        ]);

        return response()->json(['success' => 'Employee created successfully', 'user' => $user]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json(['success' => 'Employee updated successfully']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => 'Employee deleted successfully']);
    }
}
