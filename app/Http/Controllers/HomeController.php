<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Payment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalRevenue = $this->getConfirmedPayments();
        $countReservation = $this->getAllReservation();
        $countClients = $this->getAllClients();
        $topCategoryEvents = $this->getTopCategoryEvents();
        $recentPayments = $this->getRecentPayments();

        $eventNames = $topCategoryEvents->pluck('name')->toArray();
        $reservationCounts = $topCategoryEvents->pluck('reservation_count')->toArray();

        return view('home', compact('totalRevenue', 'countReservation', 'countClients', 'topCategoryEvents', 'eventNames', 'reservationCounts', 'recentPayments'));
    }

    private function getRecentPayments()
    {
        return Payment::orderBy('created_at', 'desc')->take(5)->get();
    }


    private function getConfirmedPayments()
    {
        return Payment::where('status', 'paid')->sum('total');
    }

    private function getAllReservation()
    {
        return count(Reservation::all());
    }

    private function getAllClients()
    {
        return count(User::where('role_id', 0)->get());
    }

    private function getTopCategoryEvents()
    {
        return \App\Models\CategoryEvent::withCount('reservation')
            ->orderBy('reservation_count', 'desc')
            ->take(4)
            ->get();
    }





}
