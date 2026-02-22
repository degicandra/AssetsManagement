@extends('layouts.authenticated')

@section('header', 'Asset Details')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
        <!-- Asset Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $asset->asset_code }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ $asset->model }} - {{ $asset->brand }}
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('assets.edit', $asset) }}" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-md font-medium flex items-center transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <button type="button" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white rounded-md font-medium flex items-center transition-colors duration-200"
                            onclick="openUpgradeModal()">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Upgrade
                    </button>
                    <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-md font-medium flex items-center transition-colors duration-200"
                                onclick="return confirm('Are you sure you want to delete this asset?')">
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
                <!-- Basic Information -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Company</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->company }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Serial Number</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->serial_number ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Model</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->model }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->type?->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Brand</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->brand }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @switch($asset->status)
                                        @case('ready_to_deploy') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200 @break
                                        @case('deployed') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 @break
                                        @case('archive') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200 @break
                                        @case('broken') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200 @break
                                        @case('service') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200 @break
                                        @case('request_disposal') bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-200 @break
                                        @case('disposed') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @break
                                    @endswitch">
                                    {{ ucfirst(str_replace('_', ' ', $asset->status)) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Person In Charge</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->person_in_charge }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Purchase Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->purchase_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Warranty Expiration</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $asset->warranty_expiration ? $asset->warranty_expiration->format('M d, Y') : 'N/A' }}
                            </dd>
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Location Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Department</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->department->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Floor</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $asset->location->floor->name ?? 'N/A' }} ({{ $asset->location->floor->floor_number ?? '' }})
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->location->name ?? 'N/A' }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Specifications -->
                @if($asset->processor || $asset->storage_type || $asset->storage_size || $asset->ram || $asset->specification_upgraded)
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Specifications</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($asset->processor)
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Processor</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->processor }}</dd>
                        </div>
                        @endif
                        @if($asset->storage_type)
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Storage Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->storage_type }}</dd>
                        </div>
                        @endif
                        @if($asset->storage_size)
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Storage Size</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->storage_size }}</dd>
                        </div>
                        @endif
                        @if($asset->ram)
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">RAM</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->ram }}</dd>
                        </div>
                        @endif
                        @if($asset->specification_upgraded)
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Specification Upgraded</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $asset->specification_upgraded }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($asset->notes)
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Notes</h2>
                    <div class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">
                        {{ $asset->notes }}
                    </div>
                </div>
                @endif

                <!-- Image -->
                @if($asset->image_path)
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Asset Image</h2>
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $asset->image_path) }}" 
                             alt="Asset Image" 
                             class="max-w-full h-auto rounded-lg shadow">
                    </div>
                </div>
                @endif
            </div>

            <!-- History -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">History</h2>
                    <div class="space-y-4">
                        @forelse($asset->histories as $history)
                            <div class="border-l-4 border-green-500 pl-4 py-2">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ ucfirst(str_replace('_', ' ', $history->action_type)) }}
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
                                @if($history->description)
                                    <div class="text-xs text-gray-500 dark:text-gray-300 mt-1">
                                        {{ $history->description }}
                                    </div>
                                @endif
                                <div class="text-xs text-gray-400 dark:text-gray-400 mt-1">
                                    {{ $history->created_at->format('M d, Y H:i') }} by {{ $history->user->name }}
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

<!-- Upgrade Modal -->
<div id="upgradeModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-100 opacity-100">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Upgrade Asset</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update component specifications</p>
            </div>
            <button type="button" 
                    onclick="closeUpgradeModal()"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <form action="{{ route('assets.upgrade', $asset) }}" method="POST" class="p-6 space-y-5">
            @csrf
            
            <div>
                <label for="component_type" class="block text-sm font-semibold text-gray-700 dark:text-white mb-2">
                    Component Type <span class="text-red-500">*</span>
                </label>
                <select name="component_type" id="component_type" required
                    class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors">
                    <option value="">-- Select Component --</option>
                    <option value="Processor">Processor</option>
                    <option value="Storage Type">Storage Type</option>
                    <option value="Storage Size">Storage Size</option>
                    <option value="RAM">RAM</option>
                    <option value="Model">Model</option>
                    <option value="Brand">Brand</option>
                </select>
                @error('component_type')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="new_specification" class="block text-sm font-semibold text-gray-700 dark:text-white mb-2">
                    New Specification <span class="text-red-500">*</span>
                </label>
                <input type="text" name="new_specification" id="new_specification" required
                    class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors"
                    placeholder="e.g., Intel i7, 16GB, 512GB SSD">
                @error('new_specification')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-white mb-2">
                    Description <span class="text-gray-500 font-normal">(Optional)</span>
                </label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900 transition-colors resize-none"
                    placeholder="Add notes about this upgrade..."></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="button" 
                        onclick="closeUpgradeModal()"
                        class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-6 py-2.5 text-sm font-bold text-white bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 active:bg-green-700 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Upgrade Asset
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openUpgradeModal() {
        const modal = document.getElementById('upgradeModal');
        modal.classList.remove('hidden');
        // Reset form
        modal.querySelector('form').reset();
    }

    function closeUpgradeModal() {
        const modal = document.getElementById('upgradeModal');
        modal.classList.add('hidden');
    }

    // Close modal when clicking backdrop
    document.getElementById('upgradeModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeUpgradeModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('upgradeModal');
            if (!modal.classList.contains('hidden')) {
                closeUpgradeModal();
            }
        }
    });
</script>
@endsection