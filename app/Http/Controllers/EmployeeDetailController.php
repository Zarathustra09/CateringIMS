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
}
