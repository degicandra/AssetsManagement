<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-200">Manage Departments</h2>
        <div class="flex gap-2">
            <button onclick="openDepartmentFormModal()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Department
            </button>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="space-y-2 mb-4 max-h-64 overflow-y-auto">
        @forelse($departments as $department)
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div>
                    <p class="font-medium text-gray-900 dark:text-gray-200">{{ $department->name }}</p>
                    @if($department->description)
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $department->description }}</p>
                    @endif
                </div>
                <div class="flex gap-2">
                    <button onclick="openDepartmentFormModal({{ $department->id }})" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm">Edit</button>
                    <button onclick="deleteDepartment({{ $department->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">Delete</button>
                </div>
            </div>
        @empty
            <div class="text-center py-6 text-gray-500 dark:text-gray-400">No departments found</div>
        @endforelse
    </div>

    @if($departments->hasPages())
        <div class="flex justify-between items-center mt-4 text-sm">
            <div class="text-gray-600 dark:text-gray-400">
                Page {{ $departments->currentPage() }} of {{ $departments->lastPage() }}
            </div>
            <div class="space-x-2">
                @if($departments->onFirstPage())
                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-500 rounded">Previous</span>
                @else
                    <button onclick="loadSettingsPage('departments', {{ $departments->currentPage() - 1 }})" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Previous</button>
                @endif
                
                @if($departments->hasMorePages())
                    <button onclick="loadSettingsPage('departments', {{ $departments->currentPage() + 1 }})" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Next</button>
                @else
                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-500 rounded">Next</span>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
    function openDepartmentFormModal(deptId = null) {
        const modalContent = document.getElementById('modal-content');
        const isEdit = !!deptId;
        
        const formHtml = `
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-200">${isEdit ? 'Edit' : 'Add'} Department</h3>
                    <button onclick="openSettingsModal('departments')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="dept-form" onsubmit="submitDepartmentForm(event, ${deptId})">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department Name *</label>
                            <input type="text" name="name" required class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200" placeholder="Enter department name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200" placeholder="Enter description" rows="3"></textarea>
                        </div>
                        <div class="flex gap-2 mt-6">
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">${isEdit ? 'Update' : 'Create'}</button>
                            <button type="button" onclick="openSettingsModal('departments')" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        `;
        modalContent.innerHTML = formHtml;
    }

    function submitDepartmentForm(event, deptId) {
        event.preventDefault();
        const formData = new FormData(event.target);
        
        fetch('/settings/departments', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(r => {
            if (r.ok) {
                openSettingsModal('departments');
            } else {
                alert('Error saving department');
            }
        });
    }

    function deleteDepartment(deptId) {
        if (confirm('Are you sure you want to delete this department?')) {
            fetch(`/departments/${deptId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(r => {
                if (r.ok) {
                    openSettingsModal('departments');
                }
            });
        }
    }

    function loadSettingsPage(type, page) {
        fetch(`/api/settings/${type}?page=${page}`)
            .then(r => r.text())
            .then(html => document.getElementById('modal-content').innerHTML = html);
    }
</script>

