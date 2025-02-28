<?php

namespace App\Http\Controllers;

use App\Models\CategoryEvent;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Inventory;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('guest.reservation.index', compact('services'));
    }

    public function create(Request $request)
    {

        $service = Service::find($request->input('service_id'));
        $categories = CategoryEvent::all();

        return view('guest.reservation.create', compact('service', 'categories'));
    }


//    public function bookingHistoryIndex()
//    {
//        $reservations = Reservation::where('user_id', Auth::id())->get();
//        return view('guest.booking_history', compact('reservations'));
//    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'event_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'message' => 'nullable|string',
        ]);

        $service = Service::find($request->input('service_id'));

        DB::beginTransaction();

        try {
//            $reservation = new Reservation([
//                'user_id' => Auth::id(),
//                'service_id' => $service->id,
//                'event_type' => $request->input('event_type'),
//                'start_date' => $request->input('start_date'),
//                'end_date' => $request->input('end_date'),
//                'message' => $request->input('message'),
//                'status' => 'pending',
//            ]);
//
//            $reservation->save();

            session([
                'total' => $service->price,
                'service_id' => $service->id,
                'description' => 'Reservation for ' . $service->name,
                'success' => 'Reservation created successfully.',
            ]);

            DB::commit();

            return view('guest.riderect');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating reservation:', ['message' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An error occurred while creating the reservation. Please try again.']);
        }
    }

    public function show($id)
    {
        $reservation = Reservation::with(['assignees.user','inventories'])->findOrFail($id);
        $existingInventories = Inventory::all();
        $employees = User::where('role_id', 1)->get(['id', 'name']);
        return view('admin.reservationitems.show', compact('reservation', 'employees', 'existingInventories'));
    }

    public function update(Request $request, $id)
    {
        Log::info('Update function called', ['request' => $request->all(), 'reservation_id' => $id]);

        $request->validate([

            'status' => 'required|string|max:50',

        ]);

        Log::info('Validation passed');

        $reservation = Reservation::findOrFail($id);
        $data = $request->all();

        $reservation->update($data);
        Log::info('reservation updated', ['reservation_id' => $reservation->id]);

        return redirect()->route('admin.reservationitems.index')->with('success', 'Reservation updated successfully.');
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $categories = CategoryEvent::all();
        return view('admin.reservationitems.edit', compact('reservation', 'categories')); // Add this line
    }

//    public function track($id)
//    {
//        $reservation = Reservation::with('service')->findOrFail($id);
//        return view('guest.track', compact('reservation'));
//    }
}
