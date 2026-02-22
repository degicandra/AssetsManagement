<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index(Request $request)
    {
        $query = Floor::query();

        // Search by name or floor_number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('floor_number', 'like', "%{$search}%");
            });
        }

        $floors = $query->orderBy('floor_number', 'asc')->paginate(15);

        return view('floors.index', compact('floors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'floor_number' => 'required|string|max:255|unique:floors,floor_number',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Floor::create($data);

        return redirect()->route('floors.index')->with('success', 'Floor created successfully.');
    }

    public function update(Request $request, Floor $floor)
    {
        $data = $request->validate([
            'floor_number' => 'required|string|max:255|unique:floors,floor_number,' . $floor->id,
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $floor->update($data);

        return redirect()->route('floors.index')->with('success', 'Floor updated successfully.');
    }

    public function destroy(Floor $floor)
    {
        $floor->delete();
        return redirect()->route('floors.index')->with('success', 'Floor deleted successfully.');
    }
}
