<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Floor;
use App\Models\Location;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('settings.users', compact('users'));
    }

    public function departments()
    {
        $departments = Department::orderBy('name')->paginate(10);
        return view('settings.departments', compact('departments'));
    }

    public function floors()
    {
        $floors = Floor::orderBy('name')->paginate(10);
        return view('settings.floors', compact('floors'));
    }

    public function locations()
    {
        $locations = Location::with('floor')->orderBy('name')->paginate(10);
        $floors = Floor::all();
        return view('settings.locations', compact('locations', 'floors'));
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
        ]);

        Department::create($request->all());

        return redirect()->back()->with('success', 'Department created successfully.');
    }

    public function storeFloor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:floors',
            'description' => 'nullable|string',
        ]);

        Floor::create($request->all());

        return redirect()->back()->with('success', 'Floor created successfully.');
    }

    public function storeLocation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations',
            'floor_id' => 'required|exists:floors,id',
            'description' => 'nullable|string',
        ]);

        Location::create($request->all());

        return redirect()->back()->with('success', 'Location created successfully.');
    }

    /**
     * Toggle dark mode and persist to session
     */
    public function toggleDarkMode(Request $request)
    {
        $isDark = $request->input('isDark', false);
        $theme = $isDark ? 'dark' : 'light';
        
        // Store in session
        session(['theme' => $theme]);
        
        // Force save session to storage
        $request->session()->save();
        
        return response()->json([
            'success' => true,
            'isDark' => $isDark,
            'theme' => session('theme')
        ], 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Modal view for settings management
     */
    public function settingsModalView($type)
    {
        $data = [];
        
        switch($type) {
            case 'users':
                $data['users'] = User::orderBy('created_at', 'desc')->paginate(5);
                return view('settings.modal.users', $data);
            
            case 'departments':
                $data['departments'] = Department::orderBy('name')->paginate(5);
                return view('settings.modal.departments', $data);
            
            case 'floors':
                $data['floors'] = Floor::orderBy('name')->paginate(5);
                return view('settings.modal.floors', $data);
            
            case 'locations':
                $data['locations'] = Location::with('floor')->orderBy('name')->paginate(5);
                $data['floors'] = Floor::all();
                return view('settings.modal.locations', $data);
            
            default:
                return response('Not found', 404);
        }
    }
}
