<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class StaffReservationController extends Controller
{
    public function index()
    {
        // Get reservations assigned to the currently logged-in staff
        $reservations = Reservation::whereHas('assignees', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('staff.staffreservation.index', compact('reservations'));
    }

    public function show($id)
    {
        // Fetch the reservation with related assignees and inventories
        $reservation = Reservation::with(['assignees.user', 'inventories'])->findOrFail($id);

        return view('staff.staffreservation.show', compact('reservation'));
    }
}
