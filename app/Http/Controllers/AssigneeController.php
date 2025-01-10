<?php

namespace App\Http\Controllers;

use App\Models\Assignee;
use Illuminate\Http\Request;

class AssigneeController extends Controller
{
    public function index()
    {
        $assignees = Assignee::with('user', 'reservation')->get();
        return response()->json($assignees);
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $assignee = Assignee::create($request->all());
        return response()->json($assignee, 200);
    }

    public function show($id)
    {
        $assignee = Assignee::with('user', 'reservation')->findOrFail($id);
        return response()->json($assignee);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reservation_items_id' => 'required|exists:reservations,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $assignee = Assignee::findOrFail($id);
        $assignee->update($request->all());
        return response()->json($assignee);
    }

    public function destroy($id)
    {
        $assignee = Assignee::findOrFail($id);
        $assignee->delete();
        return response()->json(['success' => 'Assignee deleted successfully.']);
    }
}
