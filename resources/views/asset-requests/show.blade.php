@extends('layouts.authenticated')

@section('header', 'Asset Request Details')

@section('content')
<style>
    @keyframes pulse-ring {
        0% {
            box-shadow: 0 0 0 0 currentColor;
        }
        70% {
            box-shadow: 0 0 0 8px rgba(34, 197, 94, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
        }
    }
    .animate-pulse-ring {
        animation: pulse-ring 1.5s infinite;
        color: rgb(34, 197, 94);
    }
</style>
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $assetRequest->title }}
                        </h1>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            @switch($assetRequest->status)
                                @case('request_created') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 @break
                                @case('finance_approval') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200 @break
                                @case('director_approval') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200 @break
                                @case('submitted_purchasing') bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-200 @break
                                @case('item_purchased') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200 @break
                            @endswitch">
                            {{ $assetRequest->status_display }}
                        </span>
                    </div>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Created on {{ $assetRequest->created_at->format('d M Y H:i') }}
                    </p>
                </div>
                <div class="flex flex-wrap gap-2 items-center">
                    <a href="{{ route('asset-requests.edit', $assetRequest) }}" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-md font-medium flex items-center transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('asset-requests.destroy', $assetRequest) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-md font-medium flex items-center transition-colors duration-200"
                                onclick="return confirm('Are you sure you want to delete this request?')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                    @if($assetRequest->status === 'item_purchased')
                        <form action="{{ route('asset-requests.convert-to-asset', $assetRequest) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-800 text-white rounded-md font-medium flex items-center transition-colors duration-200"
                                    onclick="return confirm('Convert this request to an asset?')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Convert to Asset
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
            <!-- Main Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Item Description -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Item Description</h2>
                    <div class="text-sm text-gray-900 dark:text-gray-100 text-left break-words">
                        {{ $assetRequest->item_description }}
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Department</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $assetRequest->department->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Floor</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if($assetRequest->floor)
                                    {{ $assetRequest->floor->name }}
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if($assetRequest->location)
                                    {{ $assetRequest->location->name }}
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Requested By</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $assetRequest->requested_by }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Request Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $assetRequest->request_date->format('d M Y') }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($assetRequest->notes)
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Notes</h2>
                    <div class="text-sm text-gray-900 dark:text-gray-100 text-left break-words">
                        {{ $assetRequest->notes }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar: History & Actions -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status History -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Status History</h2>
                    
                    @if($assetRequest->histories->count() > 0)
                        <div class="space-y-4">
                            @foreach($assetRequest->histories as $history)
                                <div class="flex gap-3">
                                    <!-- Timeline dot and line -->
                                    <div class="flex flex-col items-center">
                                        @if($loop->first)
                                            <div class="flex items-center justify-center w-6 h-6 animate-pulse-ring rounded-full">
                                                <div class="w-3 h-3 rounded-full {{ $history->status_badge_class }}"></div>
                                            </div>
                                        @else
                                            <div class="w-3 h-3 rounded-full mt-1 {{ $history->status_badge_class }}"></div>
                                        @endif
                                        @if(!$loop->last)
                                            <div class="w-0.5 bg-gray-200 dark:bg-gray-600" style="height: 50px;"></div>
                                        @endif
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 pb-2">
                                        <p class="font-medium text-sm text-gray-900 dark:text-gray-200">
                                            {{ $history->new_status_display }}
                                        </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            {{ $history->changed_at->format('d M Y H:i') }}
                                        </p>
                                        @if($history->notes)
                                            <p class="text-xs text-gray-700 dark:text-gray-300 mt-1">{{ $history->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400 text-sm">No history available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

