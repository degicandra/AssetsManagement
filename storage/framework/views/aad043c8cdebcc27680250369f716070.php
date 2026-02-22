

<?php $__env->startSection('header', 'Manage Locations'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-200">Location Management</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage office locations and their information.
            </p>
        </div>
        <button onclick="openLocationModal()" 
           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Location
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">Filter</h3>
        <form id="location-filter-form" method="GET" action="<?php echo e(route('locations.index')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                    <input type="text" name="search" id="location-search" placeholder="Search by location name..." 
                           value="<?php echo e(request('search')); ?>"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                
                <!-- Floor Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Floor</label>
                    <select name="floor_id" id="location-floor-filter" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Floors</option>
                        <?php $__currentLoopData = $floors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $floor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($floor->id); ?>" <?php echo e(request('floor_id') == $floor->id ? 'selected' : ''); ?>>Floor <?php echo e($floor->floor_number); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            
            <!-- Clear Filters Button -->
            <div class="pt-2">
                <a href="<?php echo e(route('locations.index')); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Results Count -->
    <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        <span id="location-results-count">Loading...</span>
    </div>

    <!-- Locations Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Floor
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Created
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="location-table-body">
                    <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200"><?php echo e($location->name); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200"><?php echo e($location->floor ? 'Floor ' . $location->floor->floor_number : '-'); ?></div>
                            </td>
                            <td class="px-6 py-4 max-w-md">
                                <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($location->description ?? '-'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($location->created_at->format('M d, Y')); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                                <button onclick='openEditLocationModal(<?php echo json_encode($location); ?>)' class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Edit</button>
                                <form action="<?php echo e(route('locations.destroy', $location)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <p class="text-gray-500 dark:text-gray-400">No locations found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        <?php echo e($locations->links()); ?>

    </div>
</div>

<!-- Add/Edit Location Modal -->
<div id="location-modal-container" class="hidden modal-overlay" onclick="if(event.target === this) closeLocationModal()">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 id="location-modal-title" class="text-xl font-bold text-gray-900 dark:text-gray-200">Add New Location</h3>
            <button onclick="closeLocationModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="location-form" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Floor</label>
                <select name="floor_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    <option value="">None</option>
                    <?php $__currentLoopData = $floors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $floor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($floor->id); ?>">Floor <?php echo e($floor->floor_number); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200"></textarea>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Save</button>
                <button type="button" onclick="closeLocationModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md">Cancel</button>
            </div>
        </form>
    </div>
</div>

<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50;
    }

    .modal-overlay.hidden {
        display: none;
    }

    .modal-content {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .dark .modal-content {
        background-color: #1f2937;
        color: white;
    }
</style>

<script>
    let filterTimeout;
    let isFiltering = false;

    // Function to perform AJAX filtering
    function applyLocationFilters() {
        if (isFiltering) return;
        isFiltering = true;

        const form = document.getElementById('location-filter-form');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);

        const resultsSpan = document.getElementById('location-results-count');
        if (resultsSpan) {
            resultsSpan.textContent = 'Loading...';
        }

        fetch(`<?php echo e(route('locations.index')); ?>?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Extract and update table body
            const newTbody = doc.querySelector('#location-table-body');
            const currentTbody = document.querySelector('#location-table-body');

            if (newTbody && currentTbody) {
                currentTbody.innerHTML = newTbody.innerHTML;
            }

            // Extract and update pagination
            const newPagination = doc.querySelector('.flex.justify-center');
            const currentPagination = document.querySelector('.flex.justify-center');
            
            if (newPagination && currentPagination) {
                currentPagination.innerHTML = newPagination.innerHTML;
                attachLocationPaginationHandlers(currentPagination);
            }

            updateLocationResultsCount();
            window.history.replaceState({}, '', `<?php echo e(route('locations.index')); ?>?${params.toString()}`);
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
    function attachLocationPaginationHandlers(container) {
        const links = container?.querySelectorAll('a');
        if (!links) return;

        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const href = this.getAttribute('href');
                if (!href) return;

                isFiltering = true;
                const resultsSpan = document.getElementById('location-results-count');
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

                    const newTbody = doc.querySelector('#location-table-body');
                    const currentTbody = document.querySelector('#location-table-body');

                    if (newTbody && currentTbody) {
                        currentTbody.innerHTML = newTbody.innerHTML;
                    }

                    const newPagination = doc.querySelector('.flex.justify-center');
                    const currentPagination = document.querySelector('.flex.justify-center');
                    
                    if (newPagination && currentPagination) {
                        currentPagination.innerHTML = newPagination.innerHTML;
                        attachLocationPaginationHandlers(currentPagination);
                    }

                    updateLocationResultsCount();
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

    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const paginationContainer = document.querySelector('.flex.justify-center');
        if (paginationContainer) {
            attachLocationPaginationHandlers(paginationContainer);
        }

        // Setup filter event listeners
        const searchField = document.getElementById('location-search');
        const floorField = document.getElementById('location-floor-filter');

        if (searchField) {
            searchField.addEventListener('keyup', function() {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(applyLocationFilters, 500);
            });
        }

        if (floorField) {
            floorField.addEventListener('change', applyLocationFilters);
        }

        updateLocationResultsCount();
    });

    function updateLocationResultsCount() {
        const countElement = document.getElementById('location-results-count');
        if (!countElement) return;
        
        const totalRows = document.querySelectorAll('#location-table-body tr').length;
        
        if (totalRows === 0) {
            countElement.textContent = 'No results found';
        } else if (totalRows === 1) {
            countElement.textContent = '1 location';
        } else {
            countElement.textContent = `${totalRows} locations`;
        }
    }

    // Store floors data for modal generation
    const floorsData = <?php echo json_encode($floors); ?>;

    // Generate floor options HTML
    function getFloorOptionsHtml(selectedFloorId = null) {
        let html = '<option value="">None</option>';
        floorsData.forEach(floor => {
            const selected = selectedFloorId == floor.id ? 'selected' : '';
            html += `<option value="${floor.id}" ${selected}>Floor ${floor.floor_number}</option>`;
        });
        return html;
    }

    // Modal functions
    function openLocationModal() {
        document.getElementById('location-modal-title').textContent = 'Add New Location';
        document.getElementById('location-form').action = `<?php echo e(route('locations.store')); ?>`;
        document.getElementById('location-form').method = 'POST';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.getElementById('location-form').innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Floor</label>
                <select name="floor_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                    ${getFloorOptionsHtml()}
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200"></textarea>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Save</button>
                <button type="button" onclick="closeLocationModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md">Cancel</button>
            </div>
        `;
        document.getElementById('location-modal-container').classList.remove('hidden');
    }

    function openEditLocationModal(location) {
        document.getElementById('location-modal-title').textContent = 'Edit Location';
        document.getElementById('location-form').action = `/locations/${location.id}`;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.getElementById('location-form').innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="_method" value="PUT">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                <input type="text" name="name" value="${location.name}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Floor</label>
                <select name="floor_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                    ${getFloorOptionsHtml(location.floor_id)}
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">${location.description || ''}</textarea>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Update</button>
                <button type="button" onclick="closeLocationModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md">Cancel</button>
            </div>
        `;
        document.getElementById('location-modal-container').classList.remove('hidden');
    }

    function closeLocationModal() {
        document.getElementById('location-modal-container').classList.add('hidden');
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeLocationModal();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.authenticated', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AssetsManagement\resources\views/locations/index.blade.php ENDPATH**/ ?>