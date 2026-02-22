<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Department;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        $query = License::with(['department']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('software_name', 'like', "%{$search}%")
                  ->orWhere('license_key', 'like', "%{$search}%");
            });
        }

        $licenses = $query->orderBy('created_at', 'desc')->paginate(10);
        $departments = Department::all();
        $statuses = ['active', 'inactive', 'expired_soon'];

        return view('licenses.index', compact('licenses', 'departments', 'statuses'));
    }

    public function create()
    {
        $departments = Department::all();
        $statuses = ['active', 'inactive', 'expired_soon'];
        return view('licenses.create', compact('departments', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'software_name' => 'required|string|max:255',
            'license_key' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'expiry_date' => 'required|date|after:purchase_date',
            'status' => 'required|in:active,inactive,expired_soon',
            'quantity' => 'nullable|integer|min:1',
            'department_id' => 'required|exists:departments,id',
            'notes' => 'nullable|string',
        ]);

        $license = License::create($request->all());

        return redirect()->route('licenses.index')
                        ->with('success', 'License created successfully.');
    }

    public function show(License $license)
    {
        $license->load(['licenseHistories.user', 'department']);
        return view('licenses.show', compact('license'));
    }

    public function edit(License $license)
    {
        $departments = Department::all();
        $statuses = ['active', 'inactive', 'expired_soon'];
        return view('licenses.edit', compact('license', 'departments', 'statuses'));
    }

    public function update(Request $request, License $license)
    {
        $request->validate([
            'software_name' => 'required|string|max:255',
            'license_key' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'expiry_date' => 'required|date|after:purchase_date',
            'status' => 'required|in:active,inactive,expired_soon',
            'quantity' => 'nullable|integer|min:1',
            'department_id' => 'required|exists:departments,id',
            'notes' => 'nullable|string',
        ]);

        $license->update($request->all());

        return redirect()->route('licenses.index')
                        ->with('success', 'License updated successfully.');
    }

    public function destroy(License $license)
    {
        $license->delete();

        return redirect()->route('licenses.index')
                        ->with('success', 'License deleted successfully.');
    }


    /**
     * Return modal view for licenses management
     */
    public function modalView()
    {
        $licenses = License::with(['department'])->orderBy('created_at', 'desc')->paginate(5);
        $departments = Department::all();
        
        return view('licenses.modal', compact('licenses', 'departments'));
    }
}