<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDetail;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PayPeriod; 
use App\Models\Reservation;
use Carbon\Carbon;

class PayrollController extends Controller
{
    // Display the list of payroll records
    public function index()
    {
        $payrolls = Payroll::with(['user', 'user.employeeDetail', 'payPeriod', 'reservation'])->paginate(10);
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Get all employees
        $employees = User::with('employeeDetail')->get();

        // Count pending payrolls for Bi-Monthly Employees (Pay Period ID = 2)
        $biMonthlyEmployees = $employees->where('employeeDetail.pay_period_id', 2);
        $pendingBiMonthly = 0;
        foreach ($biMonthlyEmployees as $employee) {
            $payrollCount = Payroll::where('user_id', $employee->id)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
            if ($payrollCount < 2) {
                $pendingBiMonthly++;
            }
        }

        // Count pending payrolls for Monthly Employees (Pay Period ID = 1)
        $monthlyEmployees = $employees->where('employeeDetail.pay_period_id', 1);
        $pendingMonthly = 0;
        foreach ($monthlyEmployees as $employee) {
            $payrollCount = Payroll::where('user_id', $employee->id)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
            if ($payrollCount < 1) {
                $pendingMonthly++;
            }
        }

        // Count pending payrolls for Contractual Employees (Pay Period ID = 3)
        $contractualEmployees = $employees->where('employeeDetail.pay_period_id', 3);
        $reservations = Reservation::all();
        $pendingContractual = 0;

        foreach ($contractualEmployees as $employee) {
            foreach ($reservations as $reservation) {
                $payrollExists = Payroll::where('user_id', $employee->id)
                    ->where('reservation_id', $reservation->id)
                    ->exists();

                if (!$payrollExists) {
                    $pendingContractual++;
                }
            }
        }

        return view('admin.payroll.index', compact(
            'payrolls', 'pendingBiMonthly', 'pendingMonthly', 'pendingContractual'
        ));
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

        public function show($id)
    {
        $payroll = Payroll::with(['user', 'user.employeeDetail', 'payPeriod'])->findOrFail($id); // Fetch a single payroll record

        return response()->json([
            'id' => $payroll->id,
            'employee_name' => $payroll->user->name ?? 'Unknown',
            'pay_period' => optional($payroll->user->employeeDetail->payPeriod)->name ?? 'N/A',
            'salary' => optional($payroll->user->employeeDetail)->salary ?? 'Not Available',
            'deductions' => $payroll->deductions,
            'net_salary' => $payroll->net_salary,
            'paid_at' => $payroll->paid_at ? $payroll->paid_at->format('F d, Y h:i A') : 'Not Paid',
        ]);
    }

    
    

    public function update(Request $request, $id)
    {
        $payroll = Payroll::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pay_period_id' => 'required|exists:pay_periods,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'gross_salary' => 'required|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
        ]);

        $net_salary = $request->gross_salary - $request->deductions;

        $payroll->update([
            'user_id' => $request->user_id,
            'pay_period_id' => $request->pay_period_id,
            'reservation_id' => $request->reservation_id,
            'gross_salary' => $request->gross_salary,
            'deductions' => $request->deductions,
            'net_salary' => $net_salary,
            'paid_at' => now('Asia/Manila'),
        ]);

        return response()->json(['success' => 'Payroll updated successfully']);
    }

    public function destroy($id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();

        return response()->json(['success' => 'Payroll deleted successfully']);
    }

    // Define relationship in Payroll.php
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id');
    }
}
