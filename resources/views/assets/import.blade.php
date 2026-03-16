@extends('layouts.authenticated')

@section('header', 'Import Assets')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-200">Import Assets</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Import assets from Excel/CSV file in bulk
            </p>
        </div>
        <a href="{{ route('assets.index') }}" 
           class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Assets
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Import Form -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">Upload CSV File</h3>
                
                <form action="{{ route('assets.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Select CSV File *
                        </label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 hover:border-blue-500 transition cursor-pointer" 
                             id="dropZone">
                            <input type="file" name="file" accept=".csv,.txt" required id="fileInput" class="hidden">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">CSV or TXT file only (Max 10MB)</p>
                            </div>
                        </div>
                        <div id="fileName" class="mt-2 text-sm text-gray-600 dark:text-gray-400"></div>
                        @error('file')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium transition">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3v-7"></path>
                            </svg>
                            Import Assets
                        </button>
                        <a href="{{ route('assets.download-template') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Download Template
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Instructions -->
        <div class="space-y-6">
            <!-- Template Instructions -->
            <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg p-6">
                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-3">Download Template</h4>
                <ol class="text-sm text-blue-800 dark:text-blue-300 space-y-2 list-decimal list-inside">
                    <li>Click "Download Template" button</li>
                    <li>Open the CSV file with Excel or Google Sheets</li>
                    <li>Fill in your asset data</li>
                    <li>Save as CSV format</li>
                    <li>Upload the file</li>
                </ol>
            </div>

            <!-- Supported Fields -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-200 mb-3">Field Information</h4>
                <div class="space-y-2 text-xs text-gray-600 dark:text-gray-400">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-gray-200">Required Fields:</span><br>
                        Asset Code
                    </div>
                    <div>
                        <span class="font-medium text-gray-900 dark:text-gray-200">Date Format:</span><br>
                        YYYY-MM-DD (e.g., 2024-01-15)
                    </div>
                    <div>
                        <span class="font-medium text-gray-900 dark:text-gray-200">Auto Lookup:</span><br>
                        Type, Department, Location names are auto-matched
                    </div>
                </div>
            </div>

            <!-- Format Help -->
            <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 rounded-lg p-6">
                <h4 class="text-sm font-semibold text-yellow-900 dark:text-yellow-200 mb-3">Column Order</h4>
                <ol class="text-xs text-yellow-800 dark:text-yellow-300 space-y-1 list-decimal list-inside">
                    <li>Company</li>
                    <li>Asset Code *</li>
                    <li>Serial Number</li>
                    <li>Model</li>
                    <li>Brand</li>
                    <li>Type</li>
                    <li>Status</li>
                    <li>Location</li>
                    <li>Department</li>
                    <li>Person In Charge</li>
                    <li>Purchase Date</li>
                    <li>Warranty Expiration</li>
                    <li>Processor</li>
                    <li>Storage Type</li>
                    <li>Storage Size</li>
                    <li>RAM</li>
                    <li>Specification Upgraded</li>
                    <li>Notes</li>
                    <li>Is Active</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Import Results -->
    @if(session('import_success'))
        <div class="bg-green-50 dark:bg-green-900/30 border-l-4 border-green-600 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('import_success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('import_errors'))
        <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-600 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">Some rows had errors:</p>
                    <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                        @foreach(session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');

    // Click to upload
    dropZone.addEventListener('click', () => fileInput.click());

    // Drag and drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        fileInput.files = e.dataTransfer.files;
        showFileName();
    });

    fileInput.addEventListener('change', showFileName);

    function showFileName() {
        if (fileInput.files.length > 0) {
            fileName.textContent = '✓ ' + fileInput.files[0].name;
            fileName.classList.add('text-green-600', 'dark:text-green-400');
        } else {
            fileName.textContent = '';
        }
    }
</script>
@endsection

