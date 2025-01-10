<?php

namespace App\Http\Controllers;

use App\Models\CategoryEvent;
use Illuminate\Http\Request;

class CategoryEventController extends Controller
{
    /**
     * Display a listing of the category events.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categoryEvents = CategoryEvent::all();
        return view('admin.categoryevents.index', compact('categoryEvents'));
    }

    /**
     * Store a newly created category event in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:category_events',
        ]);

        CategoryEvent::create($request->only('name'));  // Store only 'name'

        return response()->json(['success' => 'Category event created successfully']);
    }

    /**
     * Display the specified category event.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $categoryEvent = CategoryEvent::findOrFail($id);
        return response()->json($categoryEvent);
    }

    /**
     * Update the specified category event in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $categoryEvent = CategoryEvent::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:category_event,name,' . $categoryEvent->id,
        ]);

       $categoryEvent->update($request->only('name')); // Update only 'name'

        return response()->json(['success' => 'Category event updated successfully']);
    }

    /**
     * Remove the specified category event from the database.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $categoryEvent = CategoryEvent::findOrFail($id);
        $categoryEvent->delete();

        return response()->json(['success' => 'Category event deleted successfully']);
    }

    /**
     * List all category events.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $categoryEvents = CategoryEvent::all();
        return response()->json($categoryEvents);
    }

    public function create()
    {
        // Fetch all categories from the 'category_event' table
        $categories = CategoryEvent::all();

        // Return the view with the categories data
        return view('reservation.create', compact('categories'));
    }
}
