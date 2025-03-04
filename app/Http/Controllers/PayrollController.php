<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDetail;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PayPeriod; 
use App\Models\Reservation;

class PayrollController extends Controller
{
    // Display the list of payroll records
  // In PayrollController.php
public function index()
{
    $payrolls = Payroll::with(['user', 'user.employeeDetail', 'payPeriod', 'reservation'])->paginate(10);
    return view('admin.payroll.index', compact('payrolls'));
}


   

public function create()
{   
    $users = User::where('role_id', 1)->with('employeePayPeriod.payPeriod')->get();
    $payPeriods = PayPeriod::all(); 
    $reservations = Reservation::all();
    return view('admin.payroll.create', compact('users', 'payPeriods', 'reservations'));
}


    // Store a new payroll record in the database
    public function store(Request $request)
    {
    
    
        // Validate request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pay_period_id' => 'required|exists:pay_periods,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'deductions' => 'nullable|numeric|min:0',
        ]);
    
       
    
        // Fetch user salary
        $user = User::find($request->user_id);
        if (!$user) {
            return back()->withErrors(['user_id' => 'Invalid user selected.']);
        }
    
        $gross_salary = $user->employeeDetail->salary ?? 0;
        $deductions = $request->deductions ?? 0;
        $net_salary = $gross_salary - $deductions;
    
      
    
        // Create payroll entry
        $payroll = Payroll::create([
            'user_id' => $request->user_id,
            'pay_period_id' => $request->pay_period_id,
            'reservation_id' => $request->reservation_id,
            'gross_salary' => $gross_salary,
            'deductions' => $deductions,
            'net_salary' => $net_salary,
            'paid_at' => now(),
        ]);
    
        if (!$payroll) {
            return back()->withErrors(['payroll' => 'Failed to create payroll record.']);
        }
    
       
    
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
                'reservation_id' => 'required|exists:reservations,id',
                'gross_salary' => 'required|numeric|min:0',
                'deductions' => 'nullable|numeric|min:0',
            ]);

            $net_salary = $request->gross_salary - $request->deductions;

            $payroll->update([
                'user_id' => $request->user_id,
                'pay_period_id' => $request->pay_period_id,
                'pay_period_id' => $request->reservation_id,
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
       
        // Payroll.php
        public function reservation()
        {
            return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
        }


}
