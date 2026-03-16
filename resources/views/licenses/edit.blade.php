@extends('layouts.authenticated')

@section('header', 'Edit License')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit License</h2>

        <form action="{{ route('licenses.update', $license) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Software Name -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Software Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="software_name" value="{{ old('software_name', $license->software_name) }}" required
                           class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                    @error('software_name')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- License Key -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        License Key <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="license_key" value="{{ old('license_key', $license->license_key) }}" required
                           class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                    @error('license_key')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Purchase Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Purchase Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date', $license->purchase_date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                    @error('purchase_date')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expiry Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Expiry Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date', $license->expiry_date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                    @error('expiry_date')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required
                            class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                        <option value="">Select Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ old('status', $license->status) == $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Department <span class="text-red-500">*</span>
                    </label>
                    <select name="department_id" required
                            class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $license->department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Quantity
                    </label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity', $license->quantity) }}"
                           class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Notes
                    </label>
                    <textarea name="notes" rows="4"
                              class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors resize-none"
                              placeholder="Add any additional notes...">{{ old('notes', $license->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('licenses.show', $license) }}" 
                   class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 dark:bg-gray-700 hover:bg-gray-150 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 text-sm font-bold text-white bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 active:bg-green-700 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Update License
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
