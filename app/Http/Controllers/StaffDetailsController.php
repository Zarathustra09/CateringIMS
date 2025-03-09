<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffDetailsController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get the currently logged-in user

        return view('staff.staffdetail.index', compact('user'));
    }
}
