<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuItemController extends Controller
{
    public function show($menu_id)
    {
        $menuItems = MenuItem::where('menu_id', $menu_id)->get();
        return view('admin.menuItem.show', compact('menuItems', 'menu_id'));
    }

    public function showSingle($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        return response()->json($menuItem);
    }

    public function store(Request $request)
    {
        Log::log('info', 'MenuItemController@store', $request->all());

        $data = $request->all();
        $data['menu_id'] = (int) $request->input('menu_id');
        $data['price'] = (float) $request->input('price');
        $data['is_available'] = filter_var($request->input('is_available'), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        // Check if the menu_id is valid
        if (!Menu::find($data['menu_id'])) {
            return response()->json(['error' => 'Invalid menu_id'], 400);
        }

        $menuItem = MenuItem::create($data);
        return response()->json($menuItem, 201);
    }

    public function update(Request $request, $id)
    {
        Log::log('info', 'MenuItemController@update', $request->all());

        $menuItem = MenuItem::findOrFail($id);

        $data = $request->all();
        $data['menu_id'] = (int) $request->input('menu_id');
        $data['price'] = (float) $request->input('price');
        $data['is_available'] = filter_var($request->input('is_available'), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        // Check if the menu_id is valid
        if (!Menu::find($data['menu_id'])) {
            return response()->json(['error' => 'Invalid menu_id'], 400);
        }

        $menuItem->update($data);
        return response()->json($menuItem);
    }

    public function destroy($id)
    {
        MenuItem::destroy($id);
        return response()->json(null, 204);
    }
}
