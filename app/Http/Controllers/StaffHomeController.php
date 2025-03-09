<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Assignee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StaffHomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $countUnfinishedReservations = Assignee::where('user_id', auth()->id())
        ->with('reservation') // Use singular
        ->get()
        ->filter(function ($assignee) {
            return optional($assignee->reservation)->status !== 'completed'; 
        })
        ->count();
    
    $countFinishedReservations = Assignee::where('user_id', auth()->id())
        ->with('reservation') // Use singular
        ->get()
        ->filter(function ($assignee) {
            return optional($assignee->reservation)->status === 'completed'; 
        })
        ->count();

        // Count assigned reservations
        $countAssignedReservations = $this->getAssignedReservations();

        // Check if employeeDetail exists before accessing hired_at
        $hiredDate = optional($user->employeeDetail)->hired_at;

        // Calculate days as an employee (default to 0 if hired_at is null)
        $daysAsEmployee = $hiredDate ? Carbon::parse($hiredDate)->diffInDays(now()) : 0;

        return view('staff.home', compact(
            'countAssignedReservations', 
            'countUnfinishedReservations', 
            'countFinishedReservations', 
            'daysAsEmployee'
        ));
    }

    private function getAssignedReservations()
    {
        return Assignee::where('user_id', Auth::id())->count();
    }
}
