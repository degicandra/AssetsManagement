<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-200">Manage Users</h2>
        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="space-y-2 mb-4 max-h-64 overflow-y-auto">
        @forelse($users as $user)
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div>
                    <p class="font-medium text-gray-900 dark:text-gray-200">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-6 text-gray-500 dark:text-gray-400">No users found</div>
        @endforelse
    </div>

    @if($users->hasPages())
        <div class="flex justify-center gap-2 mt-4 text-sm">
            @if($users->onFirstPage())
                <span class="px-2 py-1 bg-gray-200 dark:bg-gray-700 text-gray-500 rounded">Previous</span>
            @else
                <button onclick="loadSettingsPage('users', {{ $users->currentPage() - 1 }})" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Previous</button>
            @endif
            
            @if($users->hasMorePages())
                <button onclick="loadSettingsPage('users', {{ $users->currentPage() + 1 }})" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Next</button>
            @else
                <span class="px-2 py-1 bg-gray-200 dark:bg-gray-700 text-gray-500 rounded">Next</span>
            @endif
        </div>
    @endif
</div>

<script>
    function loadSettingsPage(type, page) {
        fetch(`/api/settings/${type}?page=${page}`)
            .then(r => r.text())
            .then(html => document.getElementById('modal-content').innerHTML = html);
    }
</script>
