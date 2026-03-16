@extends('layouts.authenticated')

@section('header', 'License Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
        <!-- License Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $license->software_name }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ ucfirst(str_replace('_', ' ', $license->status)) }} • License Key: {{ $license->license_key }}
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('licenses.edit', $license) }}" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-md font-medium flex items-center transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('licenses.destroy', $license) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-md font-medium flex items-center transition-colors duration-200"
                                onclick="return confirm('Are you sure you want to delete this license?')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
            <!-- Main Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- License Information -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">License Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Software Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $license->software_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">License Key</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $license->license_key }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Purchase Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $license->purchase_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Expiry Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $license->expiry_date->format('M d, Y') }}
                                @if($license->days_until_expiry !== null)
                                    <span class="text-xs {{ $license->days_until_expiry < 30 ? 'text-red-600' : 'text-gray-500' }}">
                                        ({{ $license->days_until_expiry }} days remaining)
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Status</dt>
                            <dd class="mt-1">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $license->status_badge_class }}">
                                    {{ ucfirst(str_replace('_', ' ', $license->status)) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Department</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $license->department->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Quantity</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $license->quantity ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $license->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($license->notes)
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Notes</h2>
                    <div class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">
                        {{ $license->notes }}
                    </div>
                </div>
                @endif
            </div>

            <!-- History -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">History</h2>
                    <div class="space-y-4">
                        @forelse($license->licenseHistories as $history)
                            <div class="border-l-4 border-green-500 pl-4 py-2">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ ucfirst($history->action) }}
                                </div>
                                @if($history->field_name)
                                    <div class="text-xs text-gray-700 dark:text-gray-100 mt-1">
                                        {{ $history->field_name }}: 
                                        @if($history->old_value)
                                            <span class="line-through">{{ $history->old_value }}</span> → 
                                        @endif
                                        {{ $history->new_value }}
                                    </div>
                                @endif
                                @if($history->notes)
                                    <div class="text-xs text-gray-500 dark:text-gray-300 mt-1">
                                        {{ $history->notes }}
                                    </div>
                                @endif
                                <div class="text-xs text-gray-400 dark:text-gray-400 mt-1">
                                    {{ $history->created_at->format('M d, Y H:i') }} by {{ $history->user->name ?? 'System' }}
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-300">No history records found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
