<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDetail;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'hired_at' => 'required|date',
            'pay_period_id' => 'required|exists:pay_periods,id',
        ]);

        $employeeDetail = EmployeeDetail::create($request->all());

        return response()->json(['success' => 'Employee detail created successfully']);
    }

    public function show($id)
    {
        $user = User::with('employeeDetail')->findOrFail($id);
        return view('admin.employee.show', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $employeeDetail = EmployeeDetail::findOrFail($id);
        $employeeDetail->update($request->all());
        return response()->json(['success' => 'Employee detail updated successfully']);
    }

    public function destroy($id)
    {
        $employeeDetail = EmployeeDetail::findOrFail($id);
        $employeeDetail->delete();
        return response()->json(['success' => 'Employee detail deleted successfully']);
    }

    public function updateDetails(Request $request, $id)
    {
        // Find the employee details by user ID
        $employeeDetail = EmployeeDetail::where('user_id', $id)->first();

        if ($employeeDetail) {
            $employeeDetail->update([
                'position' => $request->position,
                'department' => $request->department,
                'salary' => $request->salary,
                'pay_period_id' => $request->pay_period,
            ]);

            return response()->json(['success' => true, 'message' => 'Employee details updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Employee details not found.'], 404);
    }

}
