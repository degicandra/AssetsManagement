@extends('layouts.authenticated')

@section('header', 'Assets Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-300">Assets</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage all company assets and track their status.
            </p>
        </div>
        <a href="{{ route('assets.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Asset
        </a>
    </div>

    <!-- Search & Filter Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <form id="filter-form" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4" method="GET" action="{{ route('assets.index') }}">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                <input type="text" name="search" id="search-input" placeholder="Search code, brand, model..." value="{{ $filters['search'] }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                <select name="type" id="type-filter" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    <option value="">All Types</option>
                    @foreach($assetTypes as $type)
                        <option value="{{ $type->id }}" {{ $filters['type'] == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" id="status-filter" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    <option value="">All Status</option>
                    <option value="ready_to_deploy" {{ $filters['status'] == 'ready_to_deploy' ? 'selected' : '' }}>Ready to Deploy</option>
                    <option value="deployed" {{ $filters['status'] == 'deployed' ? 'selected' : '' }}>Deployed</option>
                    <option value="archive" {{ $filters['status'] == 'archive' ? 'selected' : '' }}>Archive</option>
                    <option value="broken" {{ $filters['status'] == 'broken' ? 'selected' : '' }}>Broken</option>
                    <option value="service" {{ $filters['status'] == 'service' ? 'selected' : '' }}>Service</option>
                    <option value="request_disposal" {{ $filters['status'] == 'request_disposal' ? 'selected' : '' }}>Request Disposal</option>
                    <option value="disposed" {{ $filters['status'] == 'disposed' ? 'selected' : '' }}>Disposed</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department</label>
                <select name="department" id="department-filter" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $filters['department'] == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Floor</label>
                <select name="floor" id="floor-filter" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    <option value="">All Floors</option>
                    @foreach($floors as $floor)
                        <option value="{{ $floor->id }}" {{ $filters['floor'] == $floor->id ? 'selected' : '' }}>{{ $floor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location</label>
                <select name="location" id="location-filter" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    <option value="">All Locations</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ $filters['location'] == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        <div class="mt-4 flex gap-2">
            <a href="{{ route('assets.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Clear Filters
            </a>
            <span id="results-count" class="text-sm text-gray-600 dark:text-gray-400 py-2"></span>
        </div>
    </div>

    <!-- Assets Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Asset Code</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Brand</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Model</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Floor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($assets as $asset)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $asset->asset_code }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $asset->serial_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                @if($asset->type)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 rounded-full text-xs font-medium">{{ $asset->type->name }}</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300 rounded-full text-xs font-medium">Not Set</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $asset->brand }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $asset->model }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @switch($asset->status)
                                        @case('ready_to_deploy') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200 @break
                                        @case('deployed') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 @break
                                        @case('archive') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200 @break
                                        @case('broken') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200 @break
                                        @case('service') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200 @break
                                        @case('request_disposal') bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-200 @break
                                        @case('disposed') bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200 @break
                                    @endswitch">
                                    {{ ucfirst(str_replace('_', ' ', $asset->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $asset->department->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $asset->location->floor->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $asset->location->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('assets.show', $asset) }}" class="text-green-400 hover:text-green-900 dark:text-green-500 dark:hover:text-green-400" title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('assets.edit', $asset) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-500 dark:hover:text-blue-400" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus asset ini?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">Tidak ada asset</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai dengan membuat asset baru.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('assets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                            <svg class="icon-action" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Asset Baru
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($assets->hasPages())
            <div class="bg-white dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $assets->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    // Store all locations data for cascading filter
    const allLocations = {!! json_encode($locations->map(function($loc) { return ['id' => $loc->id, 'name' => $loc->name, 'floor_id' => $loc->floor_id]; })->toArray()) !!};

    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filter-form');
        const searchInput = document.getElementById('search-input');
        const typeFilter = document.getElementById('type-filter');
        const statusFilter = document.getElementById('status-filter');
        const departmentFilter = document.getElementById('department-filter');
        const floorFilter = document.getElementById('floor-filter');
        const locationFilter = document.getElementById('location-filter');
        
        let searchTimeout = null;
        let isFiltering = false;

        // Function to perform AJAX filtering
        function applyFilters() {
            if (isFiltering) return;
            isFiltering = true;

            // Get form data
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);

            // Show loading state
            const resultsSpan = document.getElementById('results-count');
            if (resultsSpan) {
                resultsSpan.textContent = 'Loading...';
            }

            // Fetch filtered results
            fetch(`{{ route('assets.index') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Parse response HTML
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Find the main content area in current page
                const currentMain = document.querySelector('main');
                
                // Extract the new main content from response
                const newMain = doc.querySelector('main');
                
                if (newMain && currentMain) {
                    // Replace the entire main content (keeps the sidebar intact)
                    currentMain.innerHTML = newMain.innerHTML;
                    
                    // Reattach pagination handlers for the new content
                    const paginationContainer = currentMain.querySelector('.bg-white.dark\\:bg-gray-800.px-6.py-3.border-t');
                    if (paginationContainer && shouldShowPagination(paginationContainer)) {
                        attachPaginationHandlers(paginationContainer);
                    }
                }

                // Update URL without reloading
                window.history.replaceState({}, '', `{{ route('assets.index') }}?${params.toString()}`);
            })
            .catch(error => {
                console.error('Filter error:', error);
                if (resultsSpan) {
                    resultsSpan.textContent = 'Error loading results';
                }
            })
            .finally(() => {
                isFiltering = false;
            });
        }

        // Attach pagination handlers
        function attachPaginationHandlers(container) {
            const links = container?.querySelectorAll('a');
            if (!links) return;

            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Get page URL from link
                    const href = this.getAttribute('href');
                    if (!href) return;

                    isFiltering = true;
                    const resultsSpan = document.getElementById('results-count');
                    if (resultsSpan) {
                        resultsSpan.textContent = 'Loading...';
                    }

                    fetch(href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Find the main content area in current page
                        const currentMain = document.querySelector('main');
                        
                        // Extract the new main content from response
                        const newMain = doc.querySelector('main');
                        
                        if (newMain && currentMain) {
                            // Replace the entire main content (keeps the sidebar intact)
                            currentMain.innerHTML = newMain.innerHTML;
                            
                            // Reattach pagination handlers for the new content
                            const paginationContainer = currentMain.querySelector('.bg-white.dark\\:bg-gray-800.px-6.py-3.border-t');
                            if (paginationContainer && shouldShowPagination(paginationContainer)) {
                                attachPaginationHandlers(paginationContainer);
                            }
                        }

                        updateResultsCount();
                        window.history.replaceState({}, '', href);
                    })
                    .catch(error => {
                        console.error('Pagination error:', error);
                        if (resultsSpan) {
                            resultsSpan.textContent = 'Error loading results';
                        }
                    })
                    .finally(() => {
                        isFiltering = false;
                    });
                });
            });
        }

        // Check if pagination should be visible (has multiple pages)
        function shouldShowPagination(paginationContainer) {
            if (!paginationContainer) return false;
            
            // Look for navigation element with pagination links
            const nav = paginationContainer.querySelector('nav');
            if (!nav) return false;
            
            // Check if there are any clickable pagination links (not disabled)
            const enabledLinks = nav.querySelectorAll('a:not([aria-disabled="true"])');
            return enabledLinks.length > 0;
        }

        // Setup initial pagination handlers
        const initialPagination = document.querySelector('.bg-white.dark\\:bg-gray-800.px-6.py-3.border-t');
        if (initialPagination) {
            // Hide pagination if only single page on initial load
            if (!shouldShowPagination(initialPagination)) {
                initialPagination.innerHTML = '';
            } else {
                attachPaginationHandlers(initialPagination);
            }
        }

        // Add event listeners for filtering
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 500);
            });
        }
        
        if (typeFilter) typeFilter.addEventListener('change', applyFilters);
        if (statusFilter) statusFilter.addEventListener('change', applyFilters);
        if (departmentFilter) departmentFilter.addEventListener('change', applyFilters);
        if (locationFilter) locationFilter.addEventListener('change', applyFilters);
        
        if (floorFilter) {
            floorFilter.addEventListener('change', function() {
                updateLocationOptions();
                applyFilters();
            });
        }

        // Update results count
        updateResultsCount();
    });

    function updateLocationOptions() {
        const floorFilter = document.getElementById('floor-filter');
        const locationFilter = document.getElementById('location-filter');
        const selectedFloorId = floorFilter?.value || '';
        
        if (!locationFilter) return;
        
        // Store current location value
        const currentLocation = locationFilter.value;
        
        // Clear location options except "All Locations"
        locationFilter.innerHTML = '<option value="">All Locations</option>';
        
        // Filter and add locations for selected floor
        allLocations.forEach(location => {
            if (!selectedFloorId || location.floor_id == selectedFloorId) {
                const option = document.createElement('option');
                option.value = location.id;
                option.textContent = location.name;
                
                // Restore selection if still valid
                if (currentLocation == location.id) {
                    option.selected = true;
                }
                
                locationFilter.appendChild(option);
            }
        });
    }

    function updateResultsCount() {
        const countElement = document.getElementById('results-count');
        if (!countElement) return;
        
        const totalRows = document.querySelectorAll('tbody tr').length;
        
        if (totalRows === 0) {
            countElement.textContent = 'No results found';
        } else if (totalRows === 1) {
            countElement.textContent = '1 asset';
        } else {
            countElement.textContent = `${totalRows} assets`;
        }
    }
</script>

@endsection
