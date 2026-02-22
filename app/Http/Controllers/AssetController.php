<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Department;
use App\Models\Floor;
use App\Models\Location;
use App\Models\AssetType;
use App\Models\AssetHistory;
use App\Http\Requests\AssetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::with('type', 'department', 'location.floor');
        
        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('department') && $request->department) {
            $query->where('department_id', $request->department);
        }
        
        if ($request->has('type') && $request->type) {
            $query->where('type_id', $request->type);
        }
        
        if ($request->has('floor') && $request->floor) {
            $query->whereHas('location', function($q) {
                $q->where('floor_id', request('floor'));
            });
        }
        
        if ($request->has('location') && $request->location) {
            $query->where('location_id', $request->location);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('asset_code', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }
        
        // Paginate with eager loading
        $assets = $query->latest()->paginate(10);
        
        $departments = Department::all();
        $assetTypes = AssetType::where('is_active', true)->orderBy('name')->get();
        $floors = Floor::orderBy('name')->get();
        
        // Get locations based on selected floor, or all locations
        if ($request->has('floor') && $request->floor) {
            $locations = Location::where('floor_id', $request->floor)
                ->orderBy('name')
                ->get();
        } else {
            $locations = Location::orderBy('name')->get();
        }
        
        // Get current filter values for restoring in view
        $filters = [
            'search' => $request->search ?? '',
            'status' => $request->status ?? '',
            'department' => $request->department ?? '',
            'type' => $request->type ?? '',
            'floor' => $request->floor ?? '',
            'location' => $request->location ?? ''
        ];
        
        return view('assets.index', compact('assets', 'departments', 'assetTypes', 'floors', 'locations', 'filters'));
    }
    
    public function create()
    {
        $departments = Department::all();
        $floors = Floor::all();
        $locations = Location::with('floor')->get();
        $types = AssetType::where('is_active', true)->get();
        
        return view('assets.create', compact('departments', 'floors', 'locations', 'types'));
    }
    
    public function store(AssetRequest $request)
    {
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('assets', 'public');
        }
        
        $asset = Asset::create($data);
        
        // Create history record
        AssetHistory::create([
            'asset_id' => $asset->id,
            'user_id' => Auth::id(),
            'action_type' => 'created',
            'description' => 'Asset created with code: ' . $asset->asset_code
        ]);
        
        return redirect()->route('assets.index')
            ->with('success', 'Asset created successfully!');
    }
    
    public function show(Asset $asset)
    {
        $asset->load(['department', 'location.floor', 'type', 'histories.user']);
        return view('assets.show', compact('asset'));
    }
    
    public function edit(Asset $asset)
    {
        $departments = Department::all();
        $floors = Floor::all();
        $locations = Location::with('floor')->get();
        $types = AssetType::where('is_active', true)->get();
        
        return view('assets.edit', compact('asset', 'departments', 'floors', 'locations', 'types'));
    }
    
    public function update(AssetRequest $request, Asset $asset)
    {
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($asset->image_path) {
                Storage::disk('public')->delete($asset->image_path);
            }
            $data['image_path'] = $request->file('image')->store('assets', 'public');
        }
        
        // Capture old values for comparison
        $oldValues = $asset->only(['status', 'department_id', 'location_id', 'model', 'processor', 'storage_type', 'storage_size', 'ram', 'brand']);

        $oldStatus = $oldValues['status'];
        $asset->update($data);

        // Create history record if status changed
        if ($oldStatus !== $asset->status) {
            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => Auth::id(),
                'action_type' => 'status_changed',
                'field_name' => 'status',
                'old_value' => $oldStatus,
                'new_value' => $asset->status,
                'description' => 'Status changed from ' . $oldStatus . ' to ' . $asset->status
            ]);
        }

        // Department changed
        if (array_key_exists('department_id', $data) && $oldValues['department_id'] != ($data['department_id'] ?? null)) {
            $oldDept = $oldValues['department_id'] ? Department::find($oldValues['department_id'])->name ?? $oldValues['department_id'] : null;
            $newDept = $data['department_id'] ? Department::find($data['department_id'])->name ?? $data['department_id'] : null;

            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => Auth::id(),
                'action_type' => 'updated',
                'field_name' => 'department',
                'old_value' => $oldDept,
                'new_value' => $newDept,
                'description' => 'Department changed from ' . ($oldDept ?? 'N/A') . ' to ' . ($newDept ?? 'N/A')
            ]);
        }

        // Location changed
        if (array_key_exists('location_id', $data) && $oldValues['location_id'] != ($data['location_id'] ?? null)) {
            $oldLoc = $oldValues['location_id'] ? Location::find($oldValues['location_id'])->name ?? $oldValues['location_id'] : null;
            $newLoc = $data['location_id'] ? Location::find($data['location_id'])->name ?? $data['location_id'] : null;

            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => Auth::id(),
                'action_type' => 'updated',
                'field_name' => 'location',
                'old_value' => $oldLoc,
                'new_value' => $newLoc,
                'description' => 'Location changed from ' . ($oldLoc ?? 'N/A') . ' to ' . ($newLoc ?? 'N/A')
            ]);
        }

        // Specification fields changed (model, processor, storage_type, storage_size, ram, brand)
        $specFields = ['model', 'processor', 'storage_type', 'storage_size', 'ram', 'brand'];
        foreach ($specFields as $field) {
            if (array_key_exists($field, $data) && ($oldValues[$field] ?? null) != ($data[$field] ?? null)) {
                AssetHistory::create([
                    'asset_id' => $asset->id,
                    'user_id' => Auth::id(),
                    'action_type' => 'updated',
                    'field_name' => $field,
                    'old_value' => $oldValues[$field] ?? null,
                    'new_value' => $data[$field] ?? null,
                    'description' => ucfirst($field) . ' changed from ' . ($oldValues[$field] ?? 'N/A') . ' to ' . ($data[$field] ?? 'N/A')
                ]);
            }
        }
        
        return redirect()->route('assets.show', $asset)
            ->with('success', 'Asset updated successfully!');
    }
    
    public function destroy(Asset $asset)
    {
        // Store asset data before deletion for history record
        $assetId = $asset->id;
        $assetCode = $asset->asset_code;
        
        // Create history record BEFORE deleting the asset
        AssetHistory::create([
            'asset_id' => $assetId,
            'user_id' => Auth::id(),
            'action_type' => 'deleted',
            'description' => 'Asset deleted: ' . $assetCode
        ]);
        
        // Delete image if exists
        if ($asset->image_path) {
            Storage::disk('public')->delete($asset->image_path);
        }
        
        // Now delete the asset (CASCADE will handle related records)
        $asset->delete();
        
        return redirect()->route('assets.index')
            ->with('success', 'Asset deleted successfully!');
    }
    
    public function upgrade(Request $request, Asset $asset)
    {
        $request->validate([
            'component_type' => 'required|string',
            'new_specification' => 'required|string',
            'description' => 'nullable|string'
        ]);
        // Normalize component type to match asset fields (e.g. "Processor" -> "processor")
        $requested = Str::snake(Str::lower($request->component_type));

        // Fields we allow updating via upgrade
        $allowedFields = ['processor', 'storage_type', 'storage_size', 'ram', 'model', 'brand'];

        $oldValue = null;
        $newValue = $request->new_specification;

        if (in_array($requested, $allowedFields)) {
            $field = $requested;
            $oldValue = $asset->{$field} ?? null;

            // Update asset with new specification
            $asset->{$field} = $newValue;
            
            // Update specification_upgraded field with the upgrade info
            $asset->specification_upgraded = $request->component_type . ' upgraded to ' . $newValue . ' on ' . now()->format('Y-m-d H:i:s');
            
            $asset->save();
        }

        // Create history record for upgrade (include old and new values when available)
        AssetHistory::create([
            'asset_id' => $asset->id,
            'user_id' => Auth::id(),
            'action_type' => 'upgraded',
            'field_name' => $requested,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'description' => $request->description ?? ('Component upgraded: ' . $request->component_type . ' to ' . $newValue)
        ]);

        return redirect()->back()->with('success', 'Asset upgraded successfully!');
    }
    
    public function searchByCode($code)
    {
        $asset = Asset::with(['department', 'location.floor'])
            ->where('asset_code', $code)
            ->first();
        
        if ($asset) {
            return response()->json(['success' => true, 'asset' => $asset]);
        }
        
        return response()->json(['success' => false, 'message' => 'Asset not found']);
    }

    // Return filtered assets as JSON for client-side filtering
    public function jsonIndex(Request $request)
    {
        $query = Asset::with(['department', 'location.floor']);

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('department') && $request->department) {
            $query->where('department_id', $request->department);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('asset_code', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $assets = $query->orderBy('id', 'desc')->paginate(10);

        return response()->json($assets);
    }
}
