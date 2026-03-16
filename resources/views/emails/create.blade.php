@extends('layouts.authenticated')

@section('header', 'Add New Email')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
        <form action="{{ route('emails.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position -->
                <div class="md:col-span-2">
                    <label for="position" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Position/Jabatan
                    </label>
                    <input type="text" name="position" id="position" value="{{ old('position') }}" placeholder="e.g., Manager, Director, Staff"
                           class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                    @error('position')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department -->
                <div>
                    <label for="department_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Department <span class="text-red-500">*</span>
                    </label>
                    <select name="department_id" id="department_id" required
                            class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="not used" {{ old('status') == 'not used' ? 'selected' : '' }}>Not Used</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-500 dark:text-red-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors resize-none"
                              placeholder="Add any additional notes...">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('emails.index') }}" 
                   class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 text-sm font-bold text-white bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 active:bg-green-700 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Email
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
