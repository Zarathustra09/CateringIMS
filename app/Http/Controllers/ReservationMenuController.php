<?php

namespace App\Http\Controllers;

use App\Models\ReservationMenu;
use Illuminate\Http\Request;

class ReservationMenuController extends Controller
{
//    public function index()
//    {
//        $reservationMenus = ReservationMenu::all();
//        return view('admin.reservation_menus.index', compact('reservationMenus'));
//    }

    public function store(Request $request)
    {
        $reservationMenu = ReservationMenu::create($request->all());
        return response()->json($reservationMenu, 201);
    }

    public function show($id)
    {
        $reservationMenu = ReservationMenu::findOrFail($id);
        return response()->json($reservationMenu);
    }

    public function update(Request $request, $id)
    {
        $reservationMenu = ReservationMenu::findOrFail($id);
        $reservationMenu->update($request->all());
        return response()->json($reservationMenu);
    }

    public function destroy($id)
    {
        ReservationMenu::destroy($id);
        return response()->json(null, 204);
    }
}
