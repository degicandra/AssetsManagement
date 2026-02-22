<?php

namespace App\Http\Controllers;

use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = AssetType::query();

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $types = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:asset_types,name',
            'description' => 'nullable|string',
        ]);

        AssetType::create($data);

        return redirect()->route('types.index')->with('success', 'Asset type created successfully.');
    }

    public function update(Request $request, AssetType $type)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:asset_types,name,' . $type->id,
            'description' => 'nullable|string',
        ]);

        $type->update($data);

        return redirect()->route('types.index')->with('success', 'Asset type updated successfully.');
    }

    public function destroy(AssetType $type)
    {
        $type->delete();
        return redirect()->route('types.index')->with('success', 'Asset type deleted successfully.');
    }
}
