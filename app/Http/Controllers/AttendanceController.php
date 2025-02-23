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
        return view('admin.attendance.index', compact('attendances', 'users'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id', // Validate each user ID
            'reservation_id' => 'required|exists:reservations,id', // Ensure reservation exists
        ]);
    
        foreach ($request->user_ids as $userId) {
            Attendance::create([
                'user_id' => $userId,
                'reservation_id' => $request->reservation_id, // Associate with the current reservation
            ]);
        }
    
        return response()->json(['success' => 'Attendance records created successfully.']);
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

public function reservationAttendance($reservationId)
{
    // Find the reservation or return with error if not found
    $reservation = Reservation::find($reservationId);

    if (!$reservation) {
        return redirect()->route('admin.reservationitems.index')
                         ->with('error', 'Reservation not found.');
    }

    // Get attendance for this specific reservation
    $attendances = Attendance::where('reservation_id', $reservationId)->get();
    
    // Get all users to mark attendance
    $users = User::all(); 

    return view('admin.attendance.index', compact('reservation', 'attendances', 'users'));
}





}
