<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function showSingle($id)
    {
        $menu = Menu::with('menuItems')->findOrFail($id);
        return response()->json($menu);
    }
}
