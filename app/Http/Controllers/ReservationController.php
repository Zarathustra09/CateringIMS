<?php

namespace App\Http\Controllers;

use App\Models\CategoryEvent;
use App\Models\Menu;
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
        $menus = Menu::with('menuItems')->get(); // Fetch menus with their items

        return view('guest.reservation.create', compact('service', 'categories', 'menus'));
    }


//    public function bookingHistoryIndex()
//    {
//        $reservations = Reservation::where('user_id', Auth::id())->get();
//        return view('guest.booking_history', compact('reservations'));
//    }

    public function store(Request $request)
    {
        Log::info('Creating reservation', ['service' => $request->all()]);

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'event_name' => 'required|string',
            'event_type' => 'required|exists:category_events,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'message' => 'nullable|string',
            'selected_menus' => 'required|array|min:1',
        ]);

        $service = Service::find($request->input('service_id'));

        DB::beginTransaction();

        try {
            session([
                'total' => $service->price,
                'service_id' => $service->id,
                'event_name' => $request->input('event_name'),
                'category_event_id' => $request->input('event_type'),
                'description' => 'Reservation for ' . $service->name,
                'success' => 'Reservation created successfully.',
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'selected_menus' => $request->input('selected_menus'),
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
