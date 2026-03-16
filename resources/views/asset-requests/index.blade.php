@extends('layouts.authenticated')

@section('header', 'Asset Requests')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-800">Asset Requests</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage asset purchase requests to the purchasing department.
            </p>
        </div>
        <a href="{{ route('asset-requests.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Create New Request
        </a>
    </div>

    <!-- Search & Filter Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <form id="filter-form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" method="GET" action="{{ route('asset-requests.index') }}">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                <input type="text" name="search" id="search-input" placeholder="Search title or description..." value="{{ $filters['search'] }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" id="status-filter" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    <option value="">All Status</option>
                    <option value="request_created" {{ $filters['status'] == 'request_created' ? 'selected' : '' }}>Request Created</option>
                    <option value="finance_approval" {{ $filters['status'] == 'finance_approval' ? 'selected' : '' }}>Finance Approval</option>
                    <option value="director_approval" {{ $filters['status'] == 'director_approval' ? 'selected' : '' }}>Director Approval</option>
                    <option value="submitted_purchasing" {{ $filters['status'] == 'submitted_purchasing' ? 'selected' : '' }}>Submitted to Purchasing</option>
                    <option value="item_purchased" {{ $filters['status'] == 'item_purchased' ? 'selected' : '' }}>Item Purchased</option>
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
        </form>
        <div class="mt-4 flex gap-2">
            <a href="{{ route('asset-requests.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Clear Filters
            </a>
        </div>
    </div>

    <!-- Asset Requests Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Requested By</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($assetRequests as $request)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $request->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $request->department->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $request->requested_by }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $request->request_date->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @switch($request->status)
                                        @case('request_created') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 @break
                                        @case('finance_approval') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200 @break
                                        @case('director_approval') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200 @break
                                        @case('submitted_purchasing') bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-200 @break
                                        @case('item_purchased') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200 @break
                                    @endswitch">
                                    {{ $request->status_display }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('asset-requests.show', $request) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('asset-requests.edit', $request) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('asset-requests.destroy', $request) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete" onclick="return confirm('Are you sure you want to delete this request?')">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">No requests found</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Create a new asset request to get started.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('asset-requests.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            New Request
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
        @if($assetRequests->hasPages())
            <div class="bg-white dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $assetRequests->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filter-form');
        const searchInput = document.getElementById('search-input');
        const statusFilter = document.getElementById('status-filter');
        const departmentFilter = document.getElementById('department-filter');
        
        let isFiltering = false;

        function applyFilters() {
            if (isFiltering) return;
            isFiltering = true;

            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);

            fetch(`{{ route('asset-requests.index') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const currentMain = document.querySelector('main');
                const newMain = doc.querySelector('main');
                
                if (newMain && currentMain) {
                    currentMain.innerHTML = newMain.innerHTML;
                }

                window.history.replaceState({}, '', `{{ route('asset-requests.index') }}?${params.toString()}`);
            })
            .catch(error => {
                console.error('Filter error:', error);
            })
            .finally(() => {
                isFiltering = false;
            });
        }

        if (searchInput) {
            searchInput.addEventListener('change', applyFilters);
        }
        
        if (statusFilter) statusFilter.addEventListener('change', applyFilters);
        if (departmentFilter) departmentFilter.addEventListener('change', applyFilters);
    });
</script>

@endsection

