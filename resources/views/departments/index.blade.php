@extends('layouts.authenticated')

@section('header', 'Manage Departments')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-800">Department Management</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage company departments and their information.
            </p>
        </div>
        <button onclick="openDepartmentModal()" 
           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Department
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">Filter</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                <input type="text" id="department-search" placeholder="Search by name..." 
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>
        
        <!-- Clear Filters Button -->
        <div class="mt-4">
            <button id="clear-department-filters-btn" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Clear Filters
            </button>
        </div>
    </div>

    <!-- Departments Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Name
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
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="department-table-body">
                    @forelse($departments as $dept)
                        <tr class="department-row hover:bg-gray-50 dark:hover:bg-gray-700 transition" data-name="{{ strtolower($dept->name) }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $dept->name }}</div>
                            </td>
                            <td class="px-6 py-4 max-w-md">
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $dept->description ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $dept->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                                <button onclick='openEditDepartmentModal({!! json_encode($dept) !!})' class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Edit</button>
                                <form action="{{ route('departments.destroy', $dept) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <p class="text-gray-500 dark:text-gray-400">No departments found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $departments->links() }}
    </div>
</div>

<!-- Add/Edit Department Modal -->
<div id="department-modal-container" class="hidden modal-overlay" onclick="if(event.target === this) closeDepartmentModal()">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 id="department-modal-title" class="text-xl font-bold text-gray-900 dark:text-gray-200">Add New Department</h3>
            <button onclick="closeDepartmentModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="department-form" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200"></textarea>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Save</button>
                <button type="button" onclick="closeDepartmentModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md">Cancel</button>
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
    // Filter functionality
    document.getElementById('department-search').addEventListener('keyup', filterDepartmentTable);
    document.getElementById('clear-department-filters-btn').addEventListener('click', clearDepartmentFilters);

    function filterDepartmentTable() {
        const searchValue = document.getElementById('department-search').value.toLowerCase();
        const rows = document.querySelectorAll('.department-row');

        rows.forEach(row => {
            const name = row.getAttribute('data-name');

            if (name.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function clearDepartmentFilters() {
        document.getElementById('department-search').value = '';
        filterDepartmentTable();
    }

    // Modal functions
    function openDepartmentModal() {
        document.getElementById('department-modal-title').textContent = 'Add New Department';
        document.getElementById('department-form').action = `{{ route('departments.store') }}`;
        document.getElementById('department-form').method = 'POST';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.getElementById('department-form').innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200"></textarea>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Save</button>
                <button type="button" onclick="closeDepartmentModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md">Cancel</button>
            </div>
        `;
        document.getElementById('department-modal-container').classList.remove('hidden');
    }

    function openEditDepartmentModal(dept) {
        document.getElementById('department-modal-title').textContent = 'Edit Department';
        document.getElementById('department-form').action = `/departments/${dept.id}`;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.getElementById('department-form').innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="_method" value="PUT">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                <input type="text" name="name" value="${dept.name}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">${dept.description || ''}</textarea>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">Update</button>
                <button type="button" onclick="closeDepartmentModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md">Cancel</button>
            </div>
        `;
        document.getElementById('department-modal-container').classList.remove('hidden');
    }

    function closeDepartmentModal() {
        document.getElementById('department-modal-container').classList.add('hidden');
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDepartmentModal();
        }
    });
</script>
@endsection

