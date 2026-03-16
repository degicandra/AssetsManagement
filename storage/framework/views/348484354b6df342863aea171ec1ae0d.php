

<?php $__env->startSection('header', 'Manage E-Mail'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-800">Email Management</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage company email accounts and track their status.
            </p>
        </div>
        <button onclick="openEmailModal()" 
           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Email
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">Filter</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                <input type="text" id="email-search" placeholder="Search by email or name..." 
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select id="email-status-filter" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="not used">Not Used</option>
                </select>
            </div>
        </div>
        
        <!-- Clear Filters Button -->
        <div class="mt-4">
            <button id="clear-email-filters-btn" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Clear Filters
            </button>
        </div>
    </div>

    <!-- Emails Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Position
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="emails-tbody">
                    <!-- Populated by JavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div id="emails-pagination"></div>
    </div>
</div>

<!-- Email Modal -->
<div id="email-modal-container" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 overflow-y-auto" onclick="closeEmailModal(event)">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full my-8" onclick="event.stopPropagation()">
        <div id="email-modal-content"></div>
    </div>
</div>

<script>
    let currentPage = 1;
    let lastPage = 1;
    
    // Email filtering with AJAX and pagination
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('email-search');
        const statusFilter = document.getElementById('email-status-filter');
        const clearBtn = document.getElementById('clear-email-filters-btn');
        const tbody = document.getElementById('emails-tbody');
        
        if (!tbody) return;
        
        // Debounce function to prevent too many requests
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, 500);
            };
        }
        
        // Fetch filtered emails from server
        async function fetchFilteredEmails(page = 1) {
            const searchTerm = searchInput?.value || '';
            const statusValue = statusFilter?.value || '';
            
            try {
                // Show loading state
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <svg class="animate-spin h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Loading...</span>
                            </div>
                        </td>
                    </tr>
                `;
                
                const params = new URLSearchParams();
                params.append('page', page);
                if (searchTerm) params.append('search', searchTerm);
                if (statusValue) params.append('status', statusValue);
                
                const response = await fetch(`<?php echo e(route('emails.json-filter')); ?>?${params}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });
                
                if (!response.ok) throw new Error('Failed to fetch emails');
                
                const data = await response.json();
                
                if (data.success && data.emails_formatted) {
                    currentPage = data.current_page;
                    lastPage = data.last_page;
                    renderTable(data.emails_formatted);
                    renderPagination(data.current_page, data.last_page, data.count);
                } else {
                    showNoResults();
                    renderPagination(1, 1, 0);
                }
            } catch (error) {
                console.error('Filter error:', error);
                showError('Failed to load emails. Please try again.');
            }
        }
        
        // Render the table with filtered results
        function renderTable(emails) {
            if (emails.length === 0) {
                showNoResults();
                return;
            }
            
            const statusColorMap = {
                'active': { bg: 'bg-green-100', text: 'text-green-800', darkBg: 'dark:bg-green-900/30', darkText: 'dark:text-green-200' },
                'inactive': { bg: 'bg-red-100', text: 'text-red-800', darkBg: 'dark:bg-red-900/30', darkText: 'dark:text-red-200' },
                'not used': { bg: 'bg-gray-100', text: 'text-gray-800', darkBg: 'dark:bg-gray-900/30', darkText: 'dark:text-gray-200' },
            };
            
            const rows = emails.map(email => {
                const colors = statusColorMap[email.status] || statusColorMap['active'];
                return `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-200">${escapeHtml(email.email)}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            ${escapeHtml(email.name)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            ${escapeHtml(email.position)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                            ${escapeHtml(email.department)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${colors.bg} ${colors.text} ${colors.darkBg} ${colors.darkText}">
                                ${escapeHtml(email.status_display)}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="/emails/${email.id}" 
                                   class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="/emails/${email.id}/edit" 
                                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="/emails/${email.id}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this email?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
            
            tbody.innerHTML = rows;
        }
        
        // Render pagination controls
        function renderPagination(currentPage, lastPage, total) {
            const container = document.getElementById('emails-pagination');
            if (!container) return;
            
            if (lastPage <= 1) {
                container.innerHTML = '';
                return;
            }
            
            let html = `
                <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 px-6 py-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Total: <strong>${total} email${total !== 1 ? 's' : ''}</strong>
                    </div>
                    <div class="flex space-x-2">
            `;
            
            // Previous button
            html += `
                <button onclick="goToPage(${Math.max(1, currentPage - 1)})" ${currentPage === 1 ? 'disabled' : ''}
                        class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}">
                    ← Previous
                </button>
            `;
            
            // Page numbers
            for (let i = Math.max(1, currentPage - 2); i <= Math.min(lastPage, currentPage + 2); i++) {
                if (i === currentPage) {
                    html += `
                        <button class="px-3 py-1 border border-green-500 bg-green-500 text-white rounded-md text-sm font-medium">
                            ${i}
                        </button>
                    `;
                } else {
                    html += `
                        <button onclick="goToPage(${i})"
                                class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                            ${i}
                        </button>
                    `;
                }
            }
            
            // Next button
            html += `
                <button onclick="goToPage(${Math.min(lastPage, currentPage + 1)})" ${currentPage === lastPage ? 'disabled' : ''}
                        class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 ${currentPage === lastPage ? 'opacity-50 cursor-not-allowed' : ''}">
                    Next →
                </button>
            `;
            
            html += `
                    </div>
                </div>
            `;
            
            container.innerHTML = html;
        }
        
        // Show "No results" message
        function showNoResults() {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">No emails found</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filter criteria.</p>
                        </div>
                    </td>
                </tr>
            `;
        }
        
        // Show error message
        function showError(message) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">Error loading emails</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">${message}</p>
                        </div>
                    </td>
                </tr>
            `;
        }
        
        // Escape HTML to prevent XSS
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Debounced filter function
        const debouncedFilter = debounce(() => {
            fetchFilteredEmails(1); // Reset to page 1 when filtering
        }, 500);
        
        // Event listeners
        if (searchInput) searchInput.addEventListener('keyup', debouncedFilter);
        if (statusFilter) statusFilter.addEventListener('change', () => fetchFilteredEmails(1));
        
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                if (searchInput) searchInput.value = '';
                if (statusFilter) statusFilter.value = '';
                fetchFilteredEmails(1);
            });
        }
        
        // Check for URL parameters and set filters
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');
        
        if (statusParam && statusFilter) {
            statusFilter.value = statusParam;
        }
        
        // Load emails with applied filters
        fetchFilteredEmails(1);
    });
    
    // Global function to navigate to a specific page
    function goToPage(page) {
        const searchInput = document.getElementById('email-search');
        const statusFilter = document.getElementById('email-status-filter');
        const searchTerm = searchInput?.value || '';
        const statusValue = statusFilter?.value || '';
        
        fetchFilteredEmailsGlobal(page);
    }
    
    // Global function for fetching emails from pagination
    async function fetchFilteredEmailsGlobal(page = 1) {
        const searchInput = document.getElementById('email-search');
        const statusFilter = document.getElementById('email-status-filter');
        const tbody = document.getElementById('emails-tbody');
        
        const searchTerm = searchInput?.value || '';
        const statusValue = statusFilter?.value || '';
        
        try {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <svg class="animate-spin h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-gray-600 dark:text-gray-400">Loading...</span>
                        </div>
                    </td>
                </tr>
            `;
            
            const params = new URLSearchParams();
            params.append('page', page);
            if (searchTerm) params.append('search', searchTerm);
            if (statusValue) params.append('status', statusValue);
            
            const response = await fetch(`<?php echo e(route('emails.json-filter')); ?>?${params}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });
            
            if (!response.ok) throw new Error('Failed to fetch emails');
            
            const data = await response.json();
            
            if (data.success && data.emails_formatted) {
                currentPage = data.current_page;
                lastPage = data.last_page;
                renderTable(data.emails_formatted);
                renderPagination(data.current_page, data.last_page, data.count);
            }
        } catch (error) {
            console.error('Filter error:', error);
        }
    }
    
    // Helper functions for renderTable in global scope
    function renderTable(emails) {
        const tbody = document.getElementById('emails-tbody');
        if (!tbody) return;
        
        const statusColorMap = {
            'active': { bg: 'bg-green-100', text: 'text-green-800', darkBg: 'dark:bg-green-900/30', darkText: 'dark:text-green-200' },
            'inactive': { bg: 'bg-red-100', text: 'text-red-800', darkBg: 'dark:bg-red-900/30', darkText: 'dark:text-red-200' },
            'not used': { bg: 'bg-gray-100', text: 'text-gray-800', darkBg: 'dark:bg-gray-900/30', darkText: 'dark:text-gray-200' },
        };
        
        if (emails.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">No emails found</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filter criteria.</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }
        
        const rows = emails.map(email => {
            const colors = statusColorMap[email.status] || statusColorMap['active'];
            return `
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-200">${escapeHtml(email.email)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                        ${escapeHtml(email.name)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                        ${escapeHtml(email.position)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                        ${escapeHtml(email.department)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${colors.bg} ${colors.text} ${colors.darkBg} ${colors.darkText}">
                            ${escapeHtml(email.status_display)}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="/emails/${email.id}" 
                               class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="/emails/${email.id}/edit" 
                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="/emails/${email.id}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this email?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
        
        tbody.innerHTML = rows;
    }
    
    function renderPagination(currentPage, lastPage, total) {
        const container = document.getElementById('emails-pagination');
        if (!container) return;
        
        if (lastPage <= 1) {
            container.innerHTML = '';
            return;
        }
        
        let html = `
            <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 px-6 py-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Total: <strong>${total} email${total !== 1 ? 's' : ''}</strong>
                </div>
                <div class="flex space-x-2">
        `;
        
        // Previous button
        html += `
            <button onclick="goToPage(${Math.max(1, currentPage - 1)})" ${currentPage === 1 ? 'disabled' : ''}
                    class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}">
                ← Previous
            </button>
        `;
        
        // Page numbers
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(lastPage, currentPage + 2); i++) {
            if (i === currentPage) {
                html += `
                    <button class="px-3 py-1 border border-green-500 bg-green-500 text-white rounded-md text-sm font-medium">
                        ${i}
                    </button>
                `;
            } else {
                html += `
                    <button onclick="goToPage(${i})"
                            class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        ${i}
                    </button>
                `;
            }
        }
        
        // Next button
        html += `
            <button onclick="goToPage(${Math.min(lastPage, currentPage + 1)})" ${currentPage === lastPage ? 'disabled' : ''}
                    class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 ${currentPage === lastPage ? 'opacity-50 cursor-not-allowed' : ''}">
                Next →
            </button>
        `;
        
        html += `
                </div>
            </div>
        `;
        
        container.innerHTML = html;
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Email modal functions
    function closeEmailModal(event) {
        if (event && event.target.id !== 'email-modal-container') return;
        document.getElementById('email-modal-container').classList.add('hidden');
    }
    
    function openEmailModal() {
        const container = document.getElementById('email-modal-container');
        const content = document.getElementById('email-modal-content');
        const depts = <?php echo json_encode($departments->map(fn($d) => ['id' => $d->id, 'name' => $d->name])); ?>;
        
        const deptOptions = depts.map(d => `<option value="${d.id}">${d.name}</option>`).join('');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        content.innerHTML = `
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-200">Add New Email</h3>
                    <button onclick="closeEmailModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form action="<?php echo e(route('emails.store')); ?>" method="POST" class="space-y-4">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                        <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Position/Jabatan</label>
                        <input type="text" name="position" placeholder="e.g., Manager, Director, Staff" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                        <select name="department_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                            <option value="">Select Department</option>
                            ${deptOptions}
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                        <select name="status" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="not used">Not Used</option>
                        </select>
                    </div>
                    <div class="flex gap-2 mt-6">
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Create</button>
                        <button type="button" onclick="closeEmailModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md">Cancel</button>
                    </div>
                </form>
            </div>
        `;
        container.classList.remove('hidden');
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEmailModal();
            closeLicenseModal();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.authenticated', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AssetsManagement\resources\views/emails/index.blade.php ENDPATH**/ ?>