<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->status = $request->input('status');
        $reservation->save();

        return response()->json(['success', 'Reservation updated successfully.']);
    }

}
