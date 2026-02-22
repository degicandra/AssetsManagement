@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">Settings</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Users Management -->
        <a href="{{ route('settings.users') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border border-gray-200 dark:border-gray-700 hover:border-green-500">
            <div class="text-green-600 mb-4">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-2">User Management</h3>
            <p class="text-gray-600 dark:text-gray-400">Manage system users and their permissions</p>
        </a>

        <!-- Departments Management -->
        <a href="{{ route('settings.departments') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border border-gray-200 dark:border-gray-700 hover:border-green-500">
            <div class="text-green-600 mb-4">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-2">Departments</h3>
            <p class="text-gray-600 dark:text-gray-400">Manage company departments</p>
        </a>

        <!-- Floors Management -->
        <a href="{{ route('settings.floors') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border border-gray-200 dark:border-gray-700 hover:border-green-500">
            <div class="text-green-600 mb-4">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-2">Floors</h3>
            <p class="text-gray-600 dark:text-gray-400">Manage building floors</p>
        </a>

        <!-- Locations Management -->
        <a href="{{ route('settings.locations') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border border-gray-200 dark:border-gray-700 hover:border-green-500">
            <div class="text-green-600 mb-4">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-2">Locations</h3>
            <p class="text-gray-600 dark:text-gray-400">Manage locations within floors</p>
        </a>
    </div>

    <!-- Additional Settings Recommendations -->
    <div class="mt-12 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-200 mb-4">Recommended Additional Settings</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border-l-4 border-yellow-500 pl-4">
                <h3 class="font-medium text-gray-900 dark:text-gray-200">Asset Categories</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Manage different types of assets (laptops, desktops, servers, etc.)</p>
            </div>
            <div class="border-l-4 border-yellow-500 pl-4">
                <h3 class="font-medium text-gray-900 dark:text-gray-200">Vendors/Suppliers</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Manage equipment vendors and suppliers information</p>
            </div>
            <div class="border-l-4 border-yellow-500 pl-4">
                <h3 class="font-medium text-gray-900 dark:text-gray-200">Maintenance Schedules</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Set up preventive maintenance schedules</p>
            </div>
            <div class="border-l-4 border-yellow-500 pl-4">
                <h3 class="font-medium text-gray-900 dark:text-gray-200">Notification Settings</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Configure email and system notifications</p>
            </div>
        </div>
    </div>
</div>
@endsection