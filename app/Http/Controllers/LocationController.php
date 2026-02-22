<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Floor;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $query = Location::with('floor');

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Filter by floor
        if ($request->filled('floor_id')) {
            $query->where('floor_id', $request->floor_id);
        }

        $locations = $query->orderBy('created_at', 'desc')->paginate(15);
        $floors = Floor::all();

        return view('locations.index', compact('locations', 'floors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'floor_id' => 'nullable|exists:floors,id',
            'description' => 'nullable|string',
        ]);

        Location::create($data);

        return redirect()->route('locations.index')->with('success', 'Location created successfully.');
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'floor_id' => 'nullable|exists:floors,id',
            'description' => 'nullable|string',
        ]);

        $location->update($data);

        return redirect()->route('locations.index')->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Location deleted successfully.');
    }
}
