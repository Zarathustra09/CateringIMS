<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDetail;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PayPeriod;
use App\Models\Reservation;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    // Display the list of payroll records
    public function index()
    {
        $payrolls = Payroll::with(['user', 'user.employeeDetail', 'payPeriod', 'reservation'])
            ->orderBy('id', 'desc')
            ->paginate(10);
    
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        // Get all employees
        $employees = User::with('employeeDetail.payPeriod')->get();
        $reservations = Reservation::all();
    
        // Initialize pending counters
        $pendingBiMonthly = 0;
        $pendingMonthly = 0;
        $pendingContractual = 0;
    
        // Employees without payroll categorized by Pay Period
        $employeesWithoutPayrollByType = [
            'Bi-Monthly' => [],
            'Monthly' => [],
            'Contractual' => []
        ];
    
        foreach ($employees as $employee) {
            $payPeriodId = $employee->employeeDetail->pay_period_id ?? null;
            $payrollsThisMonth = Payroll::where('user_id', $employee->id)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
    
            if ($payPeriodId == 2) { // Bi-Monthly (Should have 2 payrolls)
                if ($payrollsThisMonth < 2) {
                    $pendingBiMonthly++;
                    $employeesWithoutPayrollByType['Bi-Monthly'][] = $employee;
                }
            } elseif ($payPeriodId == 1) { // Monthly (Should have 1 payroll)
                if ($payrollsThisMonth < 1) {
                    $pendingMonthly++;
                    $employeesWithoutPayrollByType['Monthly'][] = $employee;
                }
            } elseif ($payPeriodId == 3) { // Contractual (Per Reservation)
                foreach ($reservations as $reservation) {
                    $hasPayroll = Payroll::where('user_id', $employee->id)
                        ->where('reservation_id', $reservation->id)
                        ->exists();
    
                    if (!$hasPayroll) {
                        $pendingContractual++;
                        $employeesWithoutPayrollByType['Contractual'][] = $employee;
                    }
                }
            }
        }
    
        return view('admin.payroll.index', compact(
            'payrolls',
            'pendingBiMonthly',
            'pendingMonthly',
            'pendingContractual',
            'employeesWithoutPayrollByType'
        ));
    }
    
    

    public function create()
    {
        $users = User::where('role_id', 1)->with('employeeDetail.payPeriod')->get();
        $payPeriods = PayPeriod::all();
        $reservations = Reservation::all();
    
        // Get current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        // Employees without payroll categorized by Pay Period
        $employeesWithoutPayrollByType = [
            'Bi-Monthly' => $users->where('employeeDetail.pay_period_id', 2)->filter(fn ($employee) =>
                Payroll::where('user_id', $employee->id)
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->count() < 2),
            'Monthly' => $users->where('employeeDetail.pay_period_id', 1)->filter(fn ($employee) =>
                !Payroll::where('user_id', $employee->id)
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->exists()),
            'Contractual' => $users->where('employeeDetail.pay_period_id', 3)->filter(fn ($employee) =>
                $reservations->contains(fn ($reservation) =>
                    !Payroll::where('user_id', $employee->id)
                        ->where('reservation_id', $reservation->id)
                        ->exists()))
        ];
    
        return view('admin.payroll.create', compact('users', 'payPeriods', 'reservations', 'employeesWithoutPayrollByType'));
    }
    

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
        Payroll::create([
            'user_id' => $request->user_id,
            'pay_period_id' => $request->pay_period_id,
            'reservation_id' => $request->reservation_id,
            'gross_salary' => $gross_salary,
            'deductions' => $deductions,
            'net_salary' => $net_salary,
            'paid_at' => now(),
        ]);

        return redirect()->route('admin.payroll.index')->with('success', 'Payroll record created successfully!');
    }

    public function edit($id)
    {
        $payroll = Payroll::with(['user.employeeDetail', 'payPeriod'])->findOrFail($id);
    
        return response()->json([
            'id' => $payroll->id,
            'user' => [
                'id' => $payroll->user->id ?? null,
                'name' => $payroll->user->name ?? 'Unknown',
                'employeeDetail' => [
                    'salary' => optional($payroll->user->employeeDetail)->salary ?? 0,
                ]
            ],
            'payPeriod' => [
                'id' => $payroll->payPeriod->id ?? null,
                'name' => $payroll->payPeriod->name ?? 'N/A',
            ],
            'deductions' => number_format($payroll->deductions, 2),
            'net_salary' => number_format($payroll->net_salary, 2),
        ]);
    }
    


    public function show($id)
    {
        $payroll = Payroll::with(['user', 'payPeriod', 'reservation', 'user.employeeDetail'])->find($id);
    
        if (!$payroll) {
            return response()->json(['message' => 'Payroll not found'], 404);
        }
    
        return response()->json([
            'id' => $payroll->id,
            'employee_name' => $payroll->user->name ?? 'Unknown',
            'pay_period' => $payroll->payPeriod->name ?? 'N/A',
            'salary' => rtrim(rtrim(number_format(optional($payroll->user->employeeDetail)->salary, 10, '.', ','), '0'), '.'), // Keeps full precision
            'deductions' => rtrim(rtrim(number_format($payroll->deductions, 10, '.', ','), '0'), '.'),
            'net_salary' => rtrim(rtrim(number_format($payroll->net_salary, 10, '.', ','), '0'), '.')
        ]);
    }
    


    public function update(Request $request, $id)
{
    $payroll = Payroll::findOrFail($id);

    // Validate only the fields that are actually being updated
    $request->validate([
        'gross_salary' => 'nullable|numeric|min:0',
        'deductions' => 'nullable|numeric|min:0',
    ]);

    // Get values and ensure proper calculations
    $gross_salary = $request->filled('gross_salary') ? (float) $request->gross_salary : $payroll->gross_salary;
    $deductions = $request->filled('deductions') ? (float) $request->deductions : $payroll->deductions;
    $net_salary = $gross_salary - $deductions;

    // Update payroll record
    $payroll->update([
        'gross_salary' => $gross_salary,
        'deductions' => $deductions,
        'net_salary' => $net_salary,
        'paid_at' => now('Asia/Manila'),
    ]);

    return redirect()
        ->route('admin.payroll.index')
        ->with('success', 'Payroll updated successfully!');
}




    public function destroy($id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();
        return redirect()->route('admin.payroll.index')->with('success', 'Payroll deleted successfully!');
    }

    public function downloadPDF($id)
    {
        $payroll = Payroll::findOrFail($id);
        $employeeName = str_replace(' ', '_', $payroll->user->name); // Replace spaces with underscores
    
        $pdf = Pdf::loadView('admin.payroll.pdf', compact('payroll'));
    
        return $pdf->download("Payroll_{$employeeName}.pdf");
    }
    
}
