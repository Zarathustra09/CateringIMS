<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
 use App\Models\PayPeriod;

class PayrollController extends Controller
{
    // Display the list of payroll records
  // In PayrollController.php
public function index()
{
    $payrolls = Payroll::with(['user', 'user.employeeDetail', 'payPeriod'])->paginate(10);
    return view('admin.payroll.index', compact('payrolls'));
}


   

public function create()
{
    $users = User::all();
    $payPeriods = PayPeriod::all(); // Fetch all pay periods
    return view('admin.payroll.create', compact('users', 'payPeriods'));
}


    // Store a new payroll record in the database
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pay_period_id' => 'required|exists:pay_periods,id', // Use 'pay_period_id' as it's in the database
            'deductions' => 'nullable|numeric|min:0',
        ]);
    
        // Fetch the user's salary from the employee_details table
        $user = User::find($request->user_id);
        $gross_salary = $user->employeeDetail ? $user->employeeDetail->salary : 0;
    
        // Calculate net salary
        $net_salary = $gross_salary - $request->deductions;
    
        // Create the payroll record
        Payroll::create([
            'user_id' => $request->user_id,
            'pay_period_id' => $request->pay_period_id, // Corrected to pay_period_id
            'gross_salary' => $gross_salary,
            'deductions' => $request->deductions,
            'net_salary' => $net_salary,
            'paid_at' => now(),
        ]);
    
        return redirect()->route('admin.payroll.index')->with('success', 'Payroll record created successfully!');
    }
    
    public function edit($id)
{
    // Find the payroll by its ID
    $payroll = Payroll::findOrFail($id);

    // Retrieve all users and pay periods to display in the form
    $users = User::all();
    $payPeriods = PayPeriod::all();

    // Pass the data to the edit view
    return view('admin.payroll.edit', compact('payroll', 'users', 'payPeriods'));
}
        public function update(Request $request, $id)
        {
            $payroll = Payroll::findOrFail($id);

            $request->validate([
                'user_id' => 'required|exists:users,id',
                'pay_period_id' => 'required|exists:pay_periods,id',
                'gross_salary' => 'required|numeric|min:0',
                'deductions' => 'nullable|numeric|min:0',
            ]);

            $net_salary = $request->gross_salary - $request->deductions;

            $payroll->update([
                'user_id' => $request->user_id,
                'pay_period_id' => $request->pay_period_id,
                'gross_salary' => $request->gross_salary,
                'deductions' => $request->deductions,
                'net_salary' => $net_salary,
                'paid_at' => now(),
            ]);

            return redirect()->route('admin.payroll.index')->with('success', 'Payroll record updated successfully!');
        }
        
        public function destroy($id)
        {
            $payroll = Payroll::findOrFail($id);
            $payroll->delete();

            return redirect()->route('admin.payroll.index')->with('success', 'Payroll record deleted successfully!');
        }

}
