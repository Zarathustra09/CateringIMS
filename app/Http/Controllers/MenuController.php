<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['is_active'] = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        $menu = Menu::create($data);
        return response()->json($menu, 201);
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $data = $request->all();
        $data['is_active'] = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        $menu->update($data);
        return response()->json($menu);
    }

    public function destroy($id)
    {
        Menu::destroy($id);
        return response()->json(null, 204);
    }
}
