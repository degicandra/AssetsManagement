<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-200">License Management</h2>
        <button onclick="openLicenseFormModal()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New License
        </button>
        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="overflow-x-auto mb-4">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Software</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Department</th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($licenses as $license)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-200">{{ $license->software_name }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                @if($license->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200
                                @elseif($license->status === 'inactive') bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-200
                                @elseif($license->status === 'expired_soon') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200
                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200 @endif">
                                {{ ucfirst(str_replace('_', ' ', $license->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-200">{{ $license->department?->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm text-right">
                            <button onclick="openLicenseFormModal({{ $license->id }})" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-2">Edit</button>
                            <button onclick="deleteLicense({{ $license->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No licenses found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($licenses->hasPages())
        <div class="flex justify-between items-center mt-4">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Showing {{ $licenses->firstItem() }} to {{ $licenses->lastItem() }} of {{ $licenses->total() }} results
            </div>
            <div class="space-x-2">
                @if($licenses->onFirstPage())
                    <span class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-500 rounded">Previous</span>
                @else
                    <button onclick="loadLicensePage({{ $licenses->currentPage() - 1 }})" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Previous</button>
                @endif
                
                @if($licenses->hasMorePages())
                    <button onclick="loadLicensePage({{ $licenses->currentPage() + 1 }})" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Next</button>
                @else
                    <span class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-500 rounded">Next</span>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
    function openLicenseFormModal(licenseId = null) {
        const modalContent = document.getElementById('modal-content');
        const formHtml = `
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-200">${licenseId ? 'Edit' : 'Add'} License</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="license-form" onsubmit="submitLicenseForm(event, ${licenseId})">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Software Name</label>
                            <input type="text" name="software_name" required class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">License Key</label>
                            <input type="text" name="license_key" required class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                            <select name="department_id" required class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                                <option value="">Select Department</option>
                                {{ @json($departments) }}
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" required class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="expired_soon">Expired Soon</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purchase Date</label>
                            <input type="date" name="purchase_date" required class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expiry Date</label>
                            <input type="date" name="expiry_date" required class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                        </div>
                        <div class="flex gap-2 mt-6">
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">{{ licenseId ? 'Update' : 'Create' }}</button>
                            <button type="button" onclick="openLicenseModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        `;
        modalContent.innerHTML = formHtml;
    }

    function submitLicenseForm(event, licenseId) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const method = licenseId ? 'PUT' : 'POST';
        const url = licenseId ? `/licenses/${licenseId}` : '/licenses';
        
        fetch(url, {
            method: method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                openLicenseModal();
            }
        });
    }

    function deleteLicense(licenseId) {
        if (confirm('Are you sure you want to delete this license?')) {
            fetch(`/licenses/${licenseId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    openLicenseModal();
                }
            });
        }
    }

    function loadLicensePage(page) {
        fetch(`/api/licenses?page=${page}`)
            .then(r => r.text())
            .then(html => document.getElementById('modal-content').innerHTML = html);
    }
</script>

