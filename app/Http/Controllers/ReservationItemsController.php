<?php

namespace App\Http\Controllers;

use App\Models\CategoryEvent;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Reservation;
use App\Models\ReservationItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationItemsController extends Controller
{

    public function index()
    {
        $reservations = Reservation::all();
        $categoryEvent = CategoryEvent::all();
        return view('admin.reservationitems.index', compact('reservations', 'categoryEvent'));
    }


    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'inventory_id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Retrieve the inventory and check if there's enough stock
        $inventory = Inventory::find($request->inventory_id);
        if ($inventory->quantity < $request->quantity) {
            return response()->json(['message' => 'Not enough stock available.'], 400);
        }

        // Create the reservation_item
        $reservationItem = ReservationItems::create([
            'reservation_id' => $request->reservation_id,
            'inventory_id' => $request->inventory_id,
            'quantity' => $request->quantity,
        ]);

        // Subtract the quantity from the inventory
        $inventory->quantity -= $request->quantity;
        $inventory->save();

        return response()->json(['message' => 'Inventory added successfully and stock updated.']);
    }


        public function destroy($id)
        {
            $reservationItem = ReservationItems::findOrFail($id);
            $reservationItem->delete();

            return response()->json(['message' => 'Reservation item deleted successfully']);
        }


        public function show($id)
        {
            $reservation = Reservation::with(['assignees.user', 'inventories', 'menus.menuItems'])->findOrFail($id);
            $employees = User::where('role_id', 1)->get(['id', 'name']);
            return view('admin.reservationitems.show', compact('reservation', 'employees'));
        }

        public function showSingle($id)
        {
            $reservations = Reservation::findOrFail($id);
            return response()->json($reservations);
        }

         // Add inventory to a reservation
    public function addInventory(Request $request, $id)
    {
        $request->validate([
            'inventoryId' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $reservation = Reservation::findOrFail($id);
        $inventory = Inventory::findOrFail($request->inventoryId);

        if ($inventory->quantity < $request->quantity) {
            return response()->json(['message' => 'Not enough inventory available.'], 400);
        }

        // Attach inventory to reservation
        $reservation->inventories()->attach($inventory->id, ['quantity' => $request->quantity]);

        // Decrease inventory stock
        $inventory->quantity -= $request->quantity;
        $inventory->save();

        return response()->json(['message' => 'Inventory added successfully.']);
    }

    // Edit inventory quantity in a reservation
    public function editInventory(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $reservation = Reservation::findOrFail($id);
        $inventory = Inventory::findOrFail($request->id);

        $currentQuantity = $reservation->inventories()->where('inventory_id', $inventory->id)->first()->pivot->quantity;

        // Calculate the stock adjustment
        $adjustment = $request->quantity - $currentQuantity;

        if ($inventory->quantity < $adjustment) {
            return response()->json(['message' => 'Not enough inventory available.'], 400);
        }

        // Update the pivot table quantity
        $reservation->inventories()->updateExistingPivot($inventory->id, ['quantity' => $request->quantity]);

        // Adjust inventory stock
        $inventory->quantity -= $adjustment;
        $inventory->save();

        return response()->json(['message' => 'Inventory updated successfully.']);
    }

    // Delete inventory from a reservation
    public function deleteInventory(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|exists:inventories,id',
        ]);

        $reservation = Reservation::findOrFail($id);
        $inventory = Inventory::findOrFail($request->id);

        // Get the quantity currently assigned to the reservation
        $currentQuantity = $reservation->inventories()->where('inventory_id', $inventory->id)->first()->pivot->quantity;

        // Detach the inventory from the reservation
        $reservation->inventories()->detach($inventory->id);

        // Return inventory stock
        $inventory->quantity += $currentQuantity;
        $inventory->save();

        return response()->json(['message' => 'Inventory removed successfully.']);
    }

}
