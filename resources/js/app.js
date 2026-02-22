import './bootstrap';

// Client-side filtering for assets list with real-time search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const typeFilter = document.getElementById('type-filter');
    const statusFilter = document.getElementById('status-filter');
    const departmentFilter = document.getElementById('department-filter');
    const clearBtn = document.getElementById('clear-filters-btn');
    const tbody = document.getElementById('assets-tbody');

    if (!tbody) return; // Exit if not on assets page

    let debounceTimer;
    const DEBOUNCE_DELAY = 500; // 500ms delay for search typing

    // Get CSRF token from meta tag
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    // Fetch and render assets
    async function fetchAndRender() {
        const params = new URLSearchParams();
        if (typeFilter && typeFilter.value) params.set('type', typeFilter.value);
        if (statusFilter && statusFilter.value) params.set('status', statusFilter.value);
        if (departmentFilter && departmentFilter.value) params.set('department', departmentFilter.value);
        if (searchInput && searchInput.value) params.set('search', searchInput.value);

        const url = '/assets/json?' + params.toString();

        try {
            tbody.innerHTML = '<tr><td colspan="9" class="px-6 py-4 text-center text-gray-500"><svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></td></tr>';
            
            const fetchOptions = {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                credentials: 'same-origin'
            };

            const res = await fetch(url, fetchOptions);
            
            if (!res.ok) {
                console.error('Fetch error:', res.status, res.statusText);
                const errorText = await res.text();
                console.error('Error response:', errorText);
                throw new Error(`HTTP ${res.status}: ${res.statusText}`);
            }
            
            const json = await res.json();
            const items = json.data || [];
            renderTable(items);
        } catch (err) {
            console.error('Failed to fetch assets JSON:', err);
            tbody.innerHTML = `<tr><td colspan="9" class="px-6 py-12 text-center"><div class="text-red-600 dark:text-red-400"><p class="font-semibold">Error loading assets</p><p class="text-sm mt-1">${err.message}</p></div></td></tr>`;
        }
    }

    function renderTable(items) {
        if (!items || items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No assets found</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your filters or search terms</p>
                        </div>
                    </td>
                </tr>`;
            return;
        }

        const rows = items.map(asset => {
            const statusLabel = (s) => (s || '').replace(/_/g, ' ');
            const locationName = asset.location ? (asset.location.name || '') : 'N/A';
            const floorName = asset.location && asset.location.floor ? asset.location.floor.name : '';
            const deptName = asset.department ? asset.department.name : 'N/A';
            
            // Get status badge color
            let statusBgColor = 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-200';
            switch(asset.status) {
                case 'ready_to_deploy': statusBgColor = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200'; break;
                case 'deployed': statusBgColor = 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200'; break;
                case 'archive': statusBgColor = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200'; break;
                case 'broken': statusBgColor = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200'; break;
                case 'service': statusBgColor = 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200'; break;
                case 'request_disposal': statusBgColor = 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-200'; break;
                case 'disposed': statusBgColor = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'; break;
            }

            return `
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">${asset.asset_code}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">${asset.serial_number || ''}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${asset.type || 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${asset.brand || ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${asset.model || ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statusBgColor}">${statusLabel(asset.status)}</span></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        ${locationName}${floorName ? '<div class="text-xs text-gray-500 dark:text-gray-400">' + floorName + '</div>' : ''}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${deptName}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${asset.person_in_charge || ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <a href="/assets/${asset.id}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 transition" title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="/assets/${asset.id}/edit" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>`;
        }).join('');

        tbody.innerHTML = rows;
    }

    // Real-time search with debounce (wait 500ms after user stops typing)
    if (searchInput) {
        searchInput.addEventListener('keyup', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchAndRender();
            }, DEBOUNCE_DELAY);
        });
    }

    // Immediate filter on dropdown change
    if (typeFilter) {
        typeFilter.addEventListener('change', () => {
            clearTimeout(debounceTimer);
            fetchAndRender();
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', () => {
            clearTimeout(debounceTimer);
            fetchAndRender();
        });
    }

    if (departmentFilter) {
        departmentFilter.addEventListener('change', () => {
            clearTimeout(debounceTimer);
            fetchAndRender();
        });
    }

    // Clear filters button
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            if (typeFilter) typeFilter.value = '';
            if (statusFilter) statusFilter.value = '';
            if (departmentFilter) departmentFilter.value = '';
            clearTimeout(debounceTimer);
            fetchAndRender();
        });
    }

    // Read URL parameters and apply to filters on page load
    function applyUrlFilters() {
        const params = new URLSearchParams(window.location.search);
        
        if (params.has('type') && typeFilter) {
            typeFilter.value = params.get('type');
        }
        if (params.has('status') && statusFilter) {
            statusFilter.value = params.get('status');
        }
        if (params.has('department') && departmentFilter) {
            departmentFilter.value = params.get('department');
        }
        if (params.has('search') && searchInput) {
            searchInput.value = params.get('search');
        }
    }

    // Load initial data on page load
    applyUrlFilters();
    fetchAndRender();
});
