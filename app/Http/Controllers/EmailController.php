<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\EmailHistory;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Email::with('department');

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
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        $emails = $query->latest()->paginate(15);
        $departments = Department::all();
        
        // Pass selected filters to view for UI state
        return view('emails.index', compact(
            'emails',
            'departments',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('emails.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:emails,email',
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:active,inactive,not used',
            'description' => 'nullable|string',
        ]);

        $email = Email::create($data);

        // Create history record for creation
        EmailHistory::create([
            'email_id' => $email->id,
            'user_id' => Auth::id(),
            'action_type' => 'created',
            'description' => 'Email created',
        ]);

        return redirect()->route('emails.index')->with('success', 'Email created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Email $email)
    {
        $email->load(['department', 'histories' => function($query) {
            $query->latest();
        }, 'histories.user']);
        return view('emails.show', compact('email'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Email $email)
    {
        $departments = Department::all();
        return view('emails.edit', compact('email', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Email $email)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:emails,email,' . $email->id,
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:active,inactive,not used',
            'description' => 'nullable|string',
        ]);

        // Store old values before update
        $oldData = $email->toArray();
        $email->update($data);

        // Create history records for each changed field
        foreach (['email', 'name', 'position', 'department_id', 'status', 'description'] as $field) {
            if (isset($oldData[$field]) && $oldData[$field] != $data[$field]) {
                $actionType = $field === 'status' ? 'status_changed' : 'updated';
                EmailHistory::create([
                    'email_id' => $email->id,
                    'user_id' => Auth::id(),
                    'action_type' => $actionType,
                    'field_name' => $field,
                    'old_value' => $oldData[$field],
                    'new_value' => $data[$field],
                ]);
            }
        }

        return redirect()->route('emails.show', $email)->with('success', 'Email updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email)
    {
        // Create history record for deletion
        EmailHistory::create([
            'email_id' => $email->id,
            'user_id' => Auth::id(),
            'action_type' => 'deleted',
            'description' => 'Email deleted',
        ]);

        $email->delete();
        return redirect()->route('emails.index')->with('success', 'Email deleted successfully.');
    }

    /**
     * Return filtered emails as JSON for AJAX requests with pagination
     */
    public function jsonFilter(Request $request)
    {
        $query = Email::with('department');
        $perPage = 10;
        $page = $request->get('page', 1);
        
        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Order by latest first and paginate
        $paginated = $query->latest()->paginate($perPage, ['*'], 'page', $page);
        
        return response()->json([
            'success' => true,
            'count' => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
            'emails' => $paginated->items(),
            'emails_formatted' => collect($paginated->items())->map(function($email) {
                return [
                    'id' => $email->id,
                    'email' => $email->email,
                    'name' => $email->name,
                    'position' => $email->position ?? '-',
                    'department' => $email->department?->name ?? 'N/A',
                    'status' => $email->status,
                    'status_display' => $email->status == 'not used' ? 'Not Used' : ucfirst($email->status),
                ];
            })->toArray(),
        ]);
    }
}
