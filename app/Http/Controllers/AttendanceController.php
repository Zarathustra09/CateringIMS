<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    
    public function index()
    {
        $attendances = Attendance::with(['user', 'reservation'])->latest()->get();
        $users = User::all(); // Fetch all users for dropdown
        $reservations = Reservation::all(); // Fetch all reservations for dropdown

        return view('admin.attendance.index', compact('attendances', 'users', 'reservations'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'reservation_id' => 'required|exists:reservations,id',
        ]);

        Attendance::create($validated);

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance record created successfully.');
    }

   
    public function show($id)
    {
        $attendance = Attendance::with(['user', 'reservation'])->findOrFail($id);

        return response()->json($attendance);
    }

   
    public function edit($id)
    {
        $attendance = Attendance::with(['user', 'reservation'])->findOrFail($id);
        $users = User::all();
        $reservations = Reservation::all();

        return view('admin.attendance.edit', compact('attendance', 'users', 'reservations'));
    }

    
    public function update(Request $request, $id)
{
    // Validate the request
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'reservation_id' => 'required|exists:reservations,id',
    ]);

    // Find the attendance record by ID
    $attendance = Attendance::findOrFail($id);
    
    // Update the record with validated data
    $attendance->update($validated);

    // Return a JSON response with updated data
    return response()->json([
        'success' => 'Attendance record updated successfully.',
        'data' => $attendance, // Pass the updated data
    ]);
}

   
public function destroy($id)
{
    $attendance = Attendance::findOrFail($id);
    $attendance->delete();

    return response()->json(['success' => 'Attendance record deleted successfully.']);
}

}
