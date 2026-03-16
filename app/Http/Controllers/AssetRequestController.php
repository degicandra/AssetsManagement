<?php

namespace App\Http\Controllers;

use App\Models\AssetRequest;
use App\Models\Department;
use App\Models\Floor;
use App\Models\Location;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetRequestController extends Controller
{
    /**
     * Display a listing of asset requests
     */
    public function index(Request $request)
    {
        $query = AssetRequest::with('department', 'location', 'floor');
        
        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('department') && $request->department) {
            $query->where('department_id', $request->department);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('item_description', 'like', "%{$search}%");
            });
        }
        
        $assetRequests = $query->latest('request_date')->paginate(10);
        
        $departments = Department::all();
        
        $filters = [
            'search' => $request->search ?? '',
            'status' => $request->status ?? '',
            'department' => $request->department ?? ''
        ];
        
        return view('asset-requests.index', compact('assetRequests', 'departments', 'filters'));
    }

    /**
     * Show the form for creating a new asset request
     */
    public function create()
    {
        $departments = Department::all();
        $floors = Floor::all();
        
        return view('asset-requests.create', compact('departments', 'floors'));
    }

    /**
     * Store a newly created asset request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'item_description' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'floor_id' => 'nullable|exists:floors,id',
            'location_id' => 'nullable|exists:locations,id',
            'requested_by' => 'required|string|max:255',
            'request_date' => 'required|date',
            'status' => 'required|in:request_created,finance_approval,director_approval,submitted_purchasing,item_purchased',
            'notes' => 'nullable|string'
        ]);

        AssetRequest::create($validated);

        return redirect()->route('asset-requests.index')
                       ->with('success', 'Asset request created successfully');
    }

    /**
     * Display the specified asset request
     */
    public function show(AssetRequest $assetRequest)
    {
        return view('asset-requests.show', compact('assetRequest'));
    }

    /**
     * Show the form for editing the specified asset request
     */
    public function edit(AssetRequest $assetRequest)
    {
        $departments = Department::all();
        $floors = Floor::all();
        $locations = Location::with('floor')->get();
        
        return view('asset-requests.edit', compact('assetRequest', 'departments', 'floors', 'locations'));
    }

    /**
     * Update the specified asset request
     */
    public function update(Request $request, AssetRequest $assetRequest)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'item_description' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'floor_id' => 'nullable|exists:floors,id',
            'location_id' => 'nullable|exists:locations,id',
            'requested_by' => 'required|string|max:255',
            'request_date' => 'required|date',
            'status' => 'required|in:request_created,finance_approval,director_approval,submitted_purchasing,item_purchased',
            'notes' => 'nullable|string'
        ]);

        $assetRequest->update($validated);

        return redirect()->route('asset-requests.index')
                       ->with('success', 'Asset request updated successfully');
    }

    /**
     * Remove the specified asset request
     */
    public function destroy(AssetRequest $assetRequest)
    {
        $assetRequest->delete();

        return redirect()->route('asset-requests.index')
                       ->with('success', 'Asset request deleted successfully');
    }

    /**
     * Convert asset request to asset (redirect to create form)
     */
    public function convertToAsset(AssetRequest $assetRequest)
    {
        if ($assetRequest->status !== 'item_purchased') {
            return redirect()->route('asset-requests.show', $assetRequest)
                           ->with('error', 'Asset request must have status "Item Purchased" to convert to asset');
        }

        // Store request data in session for pre-filling the form
        session([
            'from_request_id' => $assetRequest->id,
            'pre_fill_model' => $assetRequest->title,
            'pre_fill_description' => $assetRequest->item_description . ($assetRequest->notes ? "\n\n" . $assetRequest->notes : ''),
            'pre_fill_department_id' => $assetRequest->department_id,
            'pre_fill_location_id' => $assetRequest->location_id,
            'pre_fill_person_in_charge' => $assetRequest->requested_by,
            'pre_fill_purchase_date' => $assetRequest->request_date->format('Y-m-d'),
        ]);

        return redirect()->route('assets.create')
                       ->with('info', 'Fill in the asset details based on the request information');
    }
}
