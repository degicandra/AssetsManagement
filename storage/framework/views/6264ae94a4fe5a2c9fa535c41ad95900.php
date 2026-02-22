

<?php $__env->startSection('header', 'License Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-200">Licenses</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage company software licenses and track their status.
            </p>
        </div>
        <button onclick="openLicenseModal()" 
           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New License
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">Filter</h3>
        <form id="license-filter-form" method="GET" action="<?php echo e(route('licenses.index')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                    <input type="text" id="license-search" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by software name or key..." 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select id="license-status-filter" name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Statuses</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                        <option value="expired_soon" <?php echo e(request('status') == 'expired_soon' ? 'selected' : ''); ?>>Expired Soon</option>
                    </select>
                </div>
                
                <!-- Department Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Department</label>
                    <select id="license-department-filter" name="department_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Departments</option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($department->id); ?>" <?php echo e(request('department_id') == $department->id ? 'selected' : ''); ?>>
                                <?php echo e($department->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            
            <!-- Clear Filters Button -->
            <div class="pt-2">
                <a href="<?php echo e(route('licenses.index')); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
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
        <span id="license-results-count">Loading...</span>
    </div>

    <!-- Licenses Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Software Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Expiry Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="licenses-tbody">
                    <?php $__empty_1 = true; $__currentLoopData = $licenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200"><?php echo e($license->software_name); ?></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(Str::limit($license->license_key, 20)); ?>...</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200"><?php echo e($license->department?->name ?? 'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-200"><?php echo e($license->quantity ?? '-'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php if($license->status === 'active'): ?> bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                                    <?php elseif($license->status === 'inactive'): ?> bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-200
                                    <?php elseif($license->status === 'expired_soon'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                                    <?php else: ?> bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200 <?php endif; ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $license->status))); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                <?php echo e($license->expiry_date->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3 flex justify-end">
                                <a href="<?php echo e(route('licenses.show', $license)); ?>" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 transition" title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="<?php echo e(route('licenses.edit', $license)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="<?php echo e(route('licenses.destroy', $license)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this license?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">No licenses found</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your filters or add a new license.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($licenses->hasPages()): ?>
            <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <?php echo e($licenses->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<!-- License Modal -->
<div id="license-modal-container" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 overflow-y-auto" onclick="closeLicenseModal(event)">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full my-8" onclick="event.stopPropagation()">
        <div id="license-modal-content"></div>
    </div>
</div>

<script>
    let filterTimeout;
    let isFiltering = false;

    // Function to perform AJAX filtering
    function applyLicenseFilters() {
        if (isFiltering) return;
        isFiltering = true;

        const form = document.getElementById('license-filter-form');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);

        const resultsSpan = document.getElementById('license-results-count');
        if (resultsSpan) {
            resultsSpan.textContent = 'Loading...';
        }

        fetch(`<?php echo e(route('licenses.index')); ?>?${params.toString()}`, {
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
            const newTbody = doc.querySelector('#licenses-tbody');
            const currentTbody = document.querySelector('#licenses-tbody');

            if (newTbody && currentTbody) {
                currentTbody.innerHTML = newTbody.innerHTML;
            }

            // Extract and update pagination
            const newPagination = doc.querySelector('.bg-gray-50.dark\\:bg-gray-800.px-6.py-4.border-t');
            const currentPagination = document.querySelector('.bg-gray-50.dark\\:bg-gray-800.px-6.py-4.border-t');
            
            if (newPagination && currentPagination) {
                currentPagination.innerHTML = newPagination.innerHTML;
                attachLicensePaginationHandlers(currentPagination);
            }

            // Update pagination if it doesn't exist
            if (!currentPagination && newPagination) {
                const table = document.querySelector('table').closest('.bg-white');
                newPagination.classList.add('bg-gray-50', 'dark:bg-gray-800', 'px-6', 'py-4', 'border-t', 'border-gray-200', 'dark:border-gray-700');
                table.insertAdjacentHTML('afterend', newPagination.outerHTML);
                attachLicensePaginationHandlers(document.querySelector('.bg-gray-50.dark\\:bg-gray-800.px-6.py-4.border-t'));
            }

            updateLicenseResultsCount();
            window.history.replaceState({}, '', `<?php echo e(route('licenses.index')); ?>?${params.toString()}`);
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
    function attachLicensePaginationHandlers(container) {
        const links = container?.querySelectorAll('a');
        if (!links) return;

        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const href = this.getAttribute('href');
                if (!href) return;

                isFiltering = true;
                const resultsSpan = document.getElementById('license-results-count');
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

                    const newTbody = doc.querySelector('#licenses-tbody');
                    const currentTbody = document.querySelector('#licenses-tbody');

                    if (newTbody && currentTbody) {
                        currentTbody.innerHTML = newTbody.innerHTML;
                    }

                    const newPagination = doc.querySelector('.bg-gray-50.dark\\:bg-gray-800.px-6.py-4.border-t');
                    const currentPagination = document.querySelector('.bg-gray-50.dark\\:bg-gray-800.px-6.py-4.border-t');
                    
                    if (newPagination && currentPagination) {
                        currentPagination.innerHTML = newPagination.innerHTML;
                        attachLicensePaginationHandlers(currentPagination);
                    }

                    updateLicenseResultsCount();
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
        const paginationContainer = document.querySelector('.bg-gray-50.dark\\:bg-gray-800.px-6.py-4.border-t');
        if (paginationContainer) {
            attachLicensePaginationHandlers(paginationContainer);
        }

        // Setup filter event listeners
        const searchField = document.getElementById('license-search');
        const statusField = document.getElementById('license-status-filter');
        const departmentField = document.getElementById('license-department-filter');

        if (searchField) {
            searchField.addEventListener('keyup', function() {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(applyLicenseFilters, 500);
            });
        }

        if (statusField) {
            statusField.addEventListener('change', applyLicenseFilters);
        }

        if (departmentField) {
            departmentField.addEventListener('change', applyLicenseFilters);
        }

        updateLicenseResultsCount();
    });

    function updateLicenseResultsCount() {
        const countElement = document.getElementById('license-results-count');
        if (!countElement) return;
        
        const totalRows = document.querySelectorAll('#licenses-tbody tr').length;
        
        if (totalRows === 0) {
            countElement.textContent = 'No results found';
        } else if (totalRows === 1) {
            countElement.textContent = '1 license';
        } else {
            countElement.textContent = `${totalRows} licenses`;
        }
    }

    // License modal functions
    function closeLicenseModal(event) {
        if (event && event.target.id !== 'license-modal-container') return;
        document.getElementById('license-modal-container').classList.add('hidden');
    }
    
    function openLicenseModal() {
        const container = document.getElementById('license-modal-container');
        const content = document.getElementById('license-modal-content');
        const depts = <?php echo json_encode($departments->map(fn($d) => ['id' => $d->id, 'name' => $d->name])); ?>;
        
        const deptOptions = depts.map(d => `<option value="${d.id}">${d.name}</option>`).join('');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        content.innerHTML = `
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-200">Add New License</h3>
                    <button onclick="closeLicenseModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form action="<?php echo e(route('licenses.store')); ?>" method="POST" class="space-y-4">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Software Name *</label>
                        <input type="text" name="software_name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">License Key *</label>
                        <input type="text" name="license_key" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department *</label>
                        <select name="department_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                            <option value="">Select Department</option>
                            ${deptOptions}
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                        <select name="status" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="expired_soon">Expired Soon</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Purchase Date *</label>
                            <input type="date" name="purchase_date" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Expiry Date *</label>
                            <input type="date" name="expiry_date" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quantity</label>
                        <input type="number" name="quantity" min="1" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                    </div>
                    <div class="flex gap-2 mt-6">
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Create</button>
                        <button type="button" onclick="closeLicenseModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md">Cancel</button>
                    </div>
                </form>
            </div>
        `;
        container.classList.remove('hidden');
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.authenticated', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AssetsManagement\resources\views/licenses/index.blade.php ENDPATH**/ ?>