<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Assets Management') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #10B981;
            --primary-dark: #059669;
            --secondary-color: #F3F4F6;
            --text-dark: #1F2937;
            --text-light: #6B7280;
        }
        
        .dark {
            --primary-color: #10B981;
            --primary-dark: #059669;
            --secondary-color: #111827;
            --text-dark: #FFFFFF;
            --text-light: #E5E7EB;
        }
    </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-2xl font-bold text-green-600 dark:text-green-400">AssetsManagement</h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition duration-200">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="px-4 py-2 border border-green-600 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg font-medium transition duration-200">
                                    Login
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-200 mb-6">
                        Asset Management System
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                        Comprehensive solution for managing company assets, tracking inventory, 
                        monitoring licenses, and maintaining email accounts with modern interface 
                        and powerful reporting capabilities.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-2">Asset Tracking</h3>
                            <p class="text-gray-600 dark:text-gray-400">Complete inventory management with status tracking, location mapping, and detailed asset history.</p>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-2">License Management</h3>
                            <p class="text-gray-600 dark:text-gray-400">Track software licenses, monitor expiration dates, and manage license assignments across your organization.</p>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-2">Email Management</h3>
                            <p class="text-gray-600 dark:text-gray-400">Centralized email account management with department organization and status tracking.</p>
                        </div>
                    </div>

                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-200 mb-6">Key Features</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 dark:text-gray-200">Dashboard Analytics</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Real-time statistics and visual charts</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 dark:text-gray-200">Barcode Scanning</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Quick asset identification and tracking</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 dark:text-gray-200">Dark Mode</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Eye-friendly interface for all conditions</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 dark:text-gray-200">Multi-level Filtering</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Advanced search and filter capabilities</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="text-center text-gray-600 dark:text-gray-400">
                    <p>&copy; {{ date('Y') }} Assets Management System. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Dark mode toggle functionality
        if (localStorage.getItem('theme') === 'dark' || 
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>
