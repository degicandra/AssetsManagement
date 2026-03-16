@extends('layouts.authenticated')

@section('header', 'Create New Asset Request')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <form action="{{ route('asset-requests.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Title - Full Width -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Request Title *</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="e.g., Laptop for IT Staff" value="{{ old('title') }}">
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Item Description - Full Width -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Item Description *</label>
                <textarea name="item_description" required rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Describe the item details you need...">{{ old('item_description') }}</textarea>
                @error('item_description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2 Column Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Department -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department *</label>
                    <select name="department_id" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Floor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Floor (Optional)</label>
                    <select name="floor_id" id="floor_select" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Select Floor</option>
                        @foreach($floors as $floor)
                            <option value="{{ $floor->id }}" {{ old('floor_id') == $floor->id ? 'selected' : '' }}>{{ $floor->name }}</option>
                        @endforeach
                    </select>
                    @error('floor_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location - Will be populated based on floor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location (Optional)</label>
                    <select name="location_id" id="location_select" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Select Location</option>
                    </select>
                    @error('location_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Requested By - Free Text -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Requested By *</label>
                    <input type="text" name="requested_by" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Enter the name of the person requesting" value="{{ old('requested_by') }}">
                    @error('requested_by')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Request Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Request Date *</label>
                    <input type="date" name="request_date" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" value="{{ old('request_date', now()->format('Y-m-d')) }}">
                    @error('request_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Select Status</option>
                        <option value="request_created" {{ old('status') == 'request_created' ? 'selected' : '' }}>Request Created</option>
                        <option value="finance_approval" {{ old('status') == 'finance_approval' ? 'selected' : '' }}>Finance Approval</option>
                        <option value="director_approval" {{ old('status') == 'director_approval' ? 'selected' : '' }}>Director Approval</option>
                        <option value="submitted_purchasing" {{ old('status') == 'submitted_purchasing' ? 'selected' : '' }}>Submitted to Purchasing</option>
                        <option value="item_purchased" {{ old('status') == 'item_purchased' ? 'selected' : '' }}>Item Purchased</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes - Full Width -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes (Optional)</label>
                <textarea name="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Add any additional notes...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Request
                </button>
                <a href="{{ route('asset-requests.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-700 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Get all locations grouped by floor from the blade template
    const floorLocations = {
        @foreach($floors as $floor)
            {{ $floor->id }}: [
                @if($floor->locations)
                    @foreach($floor->locations as $location)
                        { id: {{ $location->id }}, name: '{{ $location->name }}' }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                @endif
            ]{{ !$loop->last ? ',' : '' }}
        @endforeach
    };

    const floorSelect = document.getElementById('floor_select');
    const locationSelect = document.getElementById('location_select');

    floorSelect.addEventListener('change', function() {
        const floorId = this.value;
        locationSelect.innerHTML = '<option value="">Select Location</option>';
        
        if (floorId && floorLocations[floorId]) {
            floorLocations[floorId].forEach(location => {
                const option = document.createElement('option');
                option.value = location.id;
                option.textContent = location.name;
                locationSelect.appendChild(option);
            });
        }
    });

    // Initialize on page load
    if (floorSelect.value) {
        floorSelect.dispatchEvent(new Event('change'));
    }
</script>
@endsection

