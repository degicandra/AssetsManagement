<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme', 'light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Assets Management') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js for dashboard charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #10B981;
            --primary-dark: #059669;
            --bg-color: #ffffff;
            --header-bg-color: #ffffff;
            --content-bg-color: #ffffff;
            --card-bg-color: #ffffff;
            --border-color: #e5e7eb;
            --text-primary-color: #1a1a1a; /* Dark text for light mode */
            --text-secondary-color: #4b5563; /* Dark secondary text for light mode */
            --text-color: #1f2937;
        }
        
        .dark {
            --primary-color: #10B981;
            --primary-dark: #059669;
            --bg-color: #111827;
            --header-bg-color: #111827;
            --content-bg-color: #111827;
            --card-bg-color: #1f2937;
            --border-color: #374151;
            --text-primary-color: #f0f0f0; /* Light text for dark mode */
            --text-secondary-color: #e5e7eb; /* Light secondary text for dark mode */
            --text-color: #f0f0f0;
        }
        
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        /* Fixed sidebar: enforce a constant width and keep footer visible
           Make only the nav area scrollable so the account/logout stays fixed */
        .sidebar-fixed {
            min-width: 16rem; /* 16rem = 256px (Tailwind w-64) */
            max-width: 16rem;
            flex: 0 0 16rem;
            height: 100vh;
            overflow: visible;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-in-out;
        }

        /* Smooth dark mode transition */
        * {
            @apply transition-colors duration-200;
        }

        /* Dark mode */
        html.dark {
            color-scheme: dark;
        }
        
        /* Dark mode hover effects for sidebar */
        html.dark .hover\:bg-gray-100:hover {
            background-color: #374151;
        }
        
        html.dark .dark\:hover\:bg-gray-700:hover {
            background-color: #374151;
        }
        
        /* Dark mode active menu text */
        html.dark .dark\:text-green-100 {
            color: #00731e !important;
        }
        
        /* Dark mode button consistency */
        html.dark .dark\:bg-gray-800 {
            background-color: #1f2937 !important;
        }
        
        html.dark .dark\:hover\:bg-gray-700:hover {
            background-color: #374151 !important;
        }
        
        /* Additional dark mode color variables */
        html.dark .dark\:bg-gray-800 {
            background-color: #1f2937 !important;
        }
        
        html.dark .dark\:border-gray-700 {
            border-color: #374151 !important;
        }
        
        html.dark .dark\:text-gray-300 {
            color: #d1d5db !important;
        }
        
        html.dark .dark\:text-gray-400 {
            color: #9ca3af !important;
        }
        
        html.dark .dark\:divide-gray-700 > :not([hidden]) ~ :not([hidden]) {
            border-color: #374151 !important;
        }        
        /* Dark mode select option styling */
        select.dark\\:bg-gray-800,
        select.dark\\:text-white,
        textarea.dark\\:text-white {
            color-scheme: dark;
        }
        
        @media (prefers-color-scheme: dark) {
            select,
            textarea,
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="date"],
            input[type="number"] {
                color-scheme: dark;
            }
        }
        
        /* Ensure text is visible in dark mode select options */
        html.dark select option {
            background-color: #1f2937;
            color: #ffffff;
        }
        
        select option:checked {
            background-color: #10B981;
            color: #ffffff;
        }
        
        /* Input field text visibility in dark mode */
        html.dark input[type="text"],
        html.dark input[type="email"],
        html.dark input[type="password"],
        html.dark input[type="date"],
        html.dark input[type="number"],
        html.dark textarea {
            color: #ffffff !important;
            background-color: #1f2937 !important;
        }

        /* Input placeholder styling in dark mode */
        html.dark input[type="text"]::placeholder,
        html.dark input[type="email"]::placeholder,
        html.dark input[type="password"]::placeholder,
        html.dark input[type="date"]::placeholder,
        html.dark input[type="number"]::placeholder,
        html.dark textarea::placeholder {
            color: #9ca3af !important;
        }
        
        /* Autofill styling for dark mode */
        html.dark input:-webkit-autofill,
        html.dark input:-webkit-autofill:hover,
        html.dark input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #1f2937 inset !important;
            -webkit-text-fill-color: #ffffff !important;
        }
        
        /* Focus state for inputs in dark mode */
        html.dark input:focus,
        html.dark textarea:focus {
            color: #ffffff !important;
        }
        
        /* Select dropdown styling for dark mode */
        html.dark select {
            color: #ffffff !important;
            background-color: #1f2937 !important;
            color-scheme: dark;
        }
        
        html.dark select option {
            background-color: #2d3748 !important;
            color: #ffffff !important;
        }
        
        html.dark select option:hover {
            background-color: #4a5568 !important;
            color: #ffffff !important;
        }
        
        html.dark select option:checked {
            background: linear-gradient(#10B981, #10B981) !important;
            background-color: #10B981 !important;
            color: #ffffff !important;
        }
        
        /* Table header and cell text visibility in dark mode */
        html.dark th {
            color: #ffffff !important;
        }
        
        html.dark td {
            color: #ffffff !important;
        }
        
        html.dark table .text-gray-900 {
            color: #ffffff !important;
        }
        
        html.dark table .dark\:text-gray-200 {
            color: #ffffff !important;
        }
        
        html.dark table .dark\:text-gray-300 {
            color: #ffffff !important;
        }
        
        /* Ensure section backgrounds toggle properly in dark mode */
        .bg-gray-50 {
            background-color: #f9fafb;
            transition: background-color 0.3s ease-in-out;
        }
        
        html.dark .dark\:bg-gray-900,
        html.dark .bg-gray-50 {
            background-color: #111827 !important;
            transition: background-color 0.3s ease-in-out;
        }
        
        /* Ensure proper text colors in dark mode for labels and headings */
        html.dark label,
        html.dark dt,
        html.dark label.block,
        html.dark label.text-gray-700 {
            color: #f3f4f6 !important;
        }
        
        html.dark h2,
        html.dark h3 {
            color: #ffffff !important;
        }
        
        /* Ensure all text elements toggle properly in dark mode */
        html.dark h1 {
            color: #ffffff !important;
        }
        
        html.dark .dark\:text-gray-200,
        html.dark .dark\:text-white,
        html.dark .dark\:text-gray-100 {
            color: #ffffff !important;
        }
        
        html.dark dd,
        html.dark .text-gray-900 {
            color: #ffffff !important;
        }
        
        html.dark .text-gray-700 {
            color: #f3f4f6 !important;
        }
        
        /* Exception for cancel buttons - keep text-gray-700 without color override in dark mode */
        html.dark a.dark\:bg-gray-700:not(:has(+ .dark\:bg-gray-700)),
        html.dark a[class*="dark:bg-gray-700"],
        html.dark button[class*="dark:bg-gray-700"] {
            color: #374151 !important;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen" style="background-color: var(--bg-color, #f9fafb);">
    <div class="flex min-h-screen">
        <!-- Sidebar (fixed) -->
        <div class="w-64 sidebar-fixed fixed left-0 top-0 h-screen z-40 border-r flex flex-col" style="background-color: var(--bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="p-4 border-b" style="border-color: var(--border-color, #e5e7eb);">
                <h1 class="text-xl font-bold" style="color: var(--text-color, #16a34a);">AssetsManagement</h1>
            </div>
            
            <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-green-100 dark:bg-green-900/30 text-green-900 dark:text-green-100' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}" style="color: var(--text-primary-color, #1a1a1a);">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('assets.index') }}" 
                   class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('assets.*') ? 'bg-green-100 dark:bg-green-900/30 text-green-900 dark:text-green-100' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}" style="color: var(--text-primary-color, #1a1a1a);">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Assets
                </a>
                
                <a href="{{ route('emails.index') }}" 
                   class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('emails.*') ? 'bg-green-100 dark:bg-green-900/30 text-green-900 dark:text-green-100' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}" style="color: var(--text-primary-color, #1a1a1a);">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Manage E-Mail
                </a>
                
                <a href="{{ route('licenses.index') }}" 
                   class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('licenses.*') ? 'bg-green-100 dark:bg-green-900/30 text-green-900 dark:text-green-100' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}" style="color: var(--text-primary-color, #1a1a1a);">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    License
                </a>
                
                <div>
                    <button id="settings-toggle" 
                            class="flex items-center w-full px-4 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition" style="color: var(--text-primary-color, #1a1a1a);">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Setting
                        <svg id="settings-arrow" class="ml-auto h-4 w-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="settings-menu" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                        <a href="{{ route('users.index') }}" class="flex items-center w-full px-8 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition" style="color: var(--text-primary-color, #1a1a1a);">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M12 4.354L8 8.354m4-4l4 4"></path>
                            </svg>
                            Manage User
                        </a>
                        <a href="{{ route('departments.index') }}" class="flex items-center w-full px-8 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition" style="color: var(--text-primary-color, #1a1a1a);">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m5.581 0a2 2 0 100-4H9m0 4a2 2 0 110-4m0 4v2m0-6V9a2 2 0 010-4h4.581m0 0h3"></path>
                            </svg>
                            Manage Department
                        </a>
                        <a href="{{ route('floors.index') }}" class="flex items-center w-full px-8 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition" style="color: var(--text-primary-color, #1a1a1a);">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                            </svg>
                            Manage Floor
                        </a>
                        <a href="{{ route('locations.index') }}" class="flex items-center w-full px-8 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition" style="color: var(--text-primary-color, #1a1a1a);">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Manage Location
                        </a>
                        <a href="{{ route('types.index') }}" class="flex items-center w-full px-8 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition" style="color: var(--text-primary-color, #1a1a1a);">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                            Manage Type
                        </a>
                    </div>
                </div>
            </nav>
            
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <span class="text-sm font-medium text-green-800 dark:text-green-100" style="color: var(--text-primary-color, #1a1a1a);">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200" style="color: var(--text-primary-color, #1a1a1a);">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-200" style="color: var(--text-secondary-color, #4b5563);">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                
                <div class="mt-3 flex space-x-2">
                    <button onclick="toggleDarkMode()" title="Toggle dark mode" class="p-2 rounded-md bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <svg id="sun-icon" class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.536l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm5.657-9.193a1 1 0 00-1.414 0l-.707.707A1 1 0 005.05 6.464l.707-.707a1 1 0 011.414 0zM5 11a1 1 0 100-2H4a1 1 0 100 2h1z" clip-rule="evenodd"></path>
                        </svg>
                        <svg id="moon-icon" class="h-5 w-5 text-indigo-400 hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>
                    
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" style="color: var(--text-primary-color, #1a1a1a);">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content (shifted to accommodate fixed sidebar) -->
        <div class="flex-1 flex flex-col overflow-hidden ml-64" style="background-color: var(--bg-color, #ffffff);">
            <!-- Top Navigation -->
            <header style="background-color: var(--header-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);" class="border-b">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-200" style="color: var(--text-primary-color, #1a1a1a);">@yield('header', 'Dashboard')</h1>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <button class="p-2 rounded-full text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6" style="background-color: var(--content-bg-color, #ffffff);">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Modal Container -->
    <div id="modal-container" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4" onclick="closeModal(event)">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-96 overflow-y-auto" onclick="event.stopPropagation()">
            <div id="modal-content"></div>
        </div>
    </div>

    <!-- Notification System -->
    @if(session('success'))
        <div id="notification-success" class="fixed top-4 right-4 z-50 bg-green-500 dark:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-slide-in">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="notification-error" class="fixed top-4 right-4 z-50 bg-red-500 dark:bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-slide-in">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <script>
        // Initialize dark mode from localStorage or system preference
        function initializeDarkMode() {
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);
            
            if (isDark) {
                document.documentElement.classList.add('dark');
                updateDarkModeIcons(true);
            } else {
                document.documentElement.classList.remove('dark');
                updateDarkModeIcons(false);
            }
        }

        // Update dark mode icons
        function updateDarkModeIcons(isDark) {
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');
            
            if (sunIcon && moonIcon) {
                if (isDark) {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                } else {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                }
            }
        }

        // Dark mode toggle
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                updateDarkModeIcons(false);
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                updateDarkModeIcons(true);
            }
            
            // Dispatch event for charts to update
            document.dispatchEvent(new CustomEvent('darkModeToggled'));
        }

        // Initialize dark mode on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeDarkMode();

            // Settings menu toggle with animation
            const settingsToggle = document.getElementById('settings-toggle');
            const settingsMenu = document.getElementById('settings-menu');
            const settingsArrow = document.getElementById('settings-arrow');
            let isOpen = false;

            if (settingsToggle && settingsMenu) {
                settingsToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    isOpen = !isOpen;

                    if (isOpen) {
                        const menuHeight = settingsMenu.scrollHeight;
                        settingsMenu.style.maxHeight = menuHeight + 'px';
                        settingsArrow.style.transform = 'rotate(180deg)';
                    } else {
                        settingsMenu.style.maxHeight = '0px';
                        settingsArrow.style.transform = 'rotate(0deg)';
                    }
                });

                const submenuLinks = settingsMenu.querySelectorAll('a');
                submenuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        isOpen = false;
                        settingsMenu.style.maxHeight = '0px';
                        settingsArrow.style.transform = 'rotate(0deg)';
                    });
                });
            }
        });

        // Modal functions
        function closeModal(event) {
            if (event && event.target.id !== 'modal-container') return;
            document.getElementById('modal-container').classList.add('hidden');
        }

        function openSettingsModal(type) {
            const container = document.getElementById('modal-container');
            const content = document.getElementById('modal-content');
            
            content.innerHTML = '<div class="p-6 text-center"><svg class="animate-spin h-8 w-8 mx-auto text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';
            container.classList.remove('hidden');
            
            fetch(`/api/settings/${type}`)
                .then(r => r.text())
                .then(html => content.innerHTML = html)
                .catch(err => {
                    console.error(`Error loading ${type}:`, err);
                    content.innerHTML = `<div class="p-6 text-center text-red-600">Error loading ${type}</div>`;
                });
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Watch for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                if (e.matches) {
                    document.documentElement.classList.add('dark');
                    updateDarkModeIcons(true);
                } else {
                    document.documentElement.classList.remove('dark');
                    updateDarkModeIcons(false);
                }
            }
        });

        // Auto-hide notifications after 5 seconds
        setTimeout(() => {
            const successNotification = document.getElementById('notification-success');
            const errorNotification = document.getElementById('notification-error');
            
            if (successNotification) {
                successNotification.style.opacity = '0';
                successNotification.style.transition = 'opacity 0.3s ease-in-out';
                setTimeout(() => successNotification.remove(), 300);
            }
            
            if (errorNotification) {
                errorNotification.style.opacity = '0';
                errorNotification.style.transition = 'opacity 0.3s ease-in-out';
                setTimeout(() => errorNotification.remove(), 300);
            }
        }, 5000);
    </script>
</body>
</html>