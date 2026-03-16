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

    <!-- Scripts and Styles (Vite imports all CSS including darkmode.css) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js for dashboard charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* ============================================================================
           LAYOUT STYLES (No Dark Mode CSS - That's in darkmode.css)
           ============================================================================ */
        
        :root {
            --primary-color: #10B981;
            --primary-dark: #059669;
        }
        
        /* Sidebar layout */
        .sidebar-fixed {
            min-width: 16rem;
            max-width: 16rem;
            flex: 0 0 16rem;
            height: 100vh;
            overflow: visible;
        }

        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        /* Animation for notifications */
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

        /* Responsive sidebar */
        @media (max-width: 1023px) {
            .sidebar-fixed {
                transform: translateX(-100%);
                transition: transform 0.25s ease-in-out;
                position: fixed;
                left: 0;
                top: 0;
                z-index: 40;
            }

            .sidebar-fixed.open {
                transform: translateX(0);
            }

            .ml-64-responsive {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="flex h-screen bg-white dark:bg-gray-900">
        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-fixed sidebar-transition bg-white dark:bg-gray-800 shadow-lg border-r border-gray-200 dark:border-gray-700 flex flex-col">
            <!-- Logo -->
            <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-2xl font-bold text-green-600">{{ config('app.name', 'Assets') }}</h1>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-green-100 dark:bg-green-900/30 text-green-900 dark:text-green-500' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4v6m4-6v6m-9-11l7-4 7 4m0 0v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9z"></path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('assets.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('assets.*') ? 'bg-green-100 dark:bg-green-900/30 text-green-900 dark:text-green-500' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Assets
                </a>

                <a href="{{ route('emails.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('emails.*') ? 'bg-green-100 dark:bg-green-900/30 text-green-900 dark:text-green-500' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Emails
                </a>

                <a href="{{ route('licenses.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('licenses.*') ? 'bg-green-100 dark:bg-green-900/30 text-green-900 dark:text-green-500' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Licenses
                </a>

                <a href="{{ route('asset-requests.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('asset-requests.*') ? 'bg-green-100 dark:bg-green-900/30 text-green-900 dark:text-green-500' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Requests
                </a>

                <!-- Settings Submenu -->
                <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                    <button id="settings-menu-toggle" class="settings-toggle w-full flex items-center justify-between px-4 py-2 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </div>
                        <!-- <svg id="settings-arrow" class="w-4 h-4 transition-transform duration-300 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg> -->
                    </button>

                    <div id="settings-submenu" class="hidden ml-8 mt-2 space-y-2">
                        <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Users</a>
                        <a href="{{ route('departments.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Departments</a>
                        <a href="{{ route('floors.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Floors</a>
                        <a href="{{ route('locations.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Locations</a>
                        <a href="{{ route('types.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">Asset Types</a>
                    </div>
                </div>
            </nav>

            <!-- Footer -->
            <div class="px-6 py-6 border-t border-gray-200 dark:border-gray-700 space-y-4">
                <!-- User Info -->
                <div class="flex items-center gap-3">
                    <!-- Avatar -->
                    <div class="w-10 h-10 rounded-full bg-green-300 dark:bg-green-900/30 text-green-900 dark:text-green-500 flex items-center justify-center flex-shrink-0">
                        <span class="text-green-900 dark:text-green-600 font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                    
                    <!-- User Details -->
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- Dark Mode Toggle -->
                <div class="flex gap-2">
                    <button onclick="toggleDarkMode()" title="Toggle dark mode" class="p-2 bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors flex-1">
                        <svg id="sun-icon" class="w-5 h-5 text-yellow-500 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v1m0 16v1m9-9h-1m-16 0H1m15.364 1.636l.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg id="moon-icon" class="w-5 h-5 text-blue-400 mx-auto hidden" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </button>

                    <!-- Logout -->
                    <form action="{{ route('logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-10 py-2 text-sm font-medium bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900">
            <!-- Top Navigation Bar -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex items-center justify-between">
                <button id="sidebar-toggle" class="lg:hidden text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">@yield('header', 'Dashboard')</h1>

                <div class="w-6"></div>
            </div>

            <!-- Page Content -->
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // ============================================================================
        // DARK MODE MANAGEMENT
        // ============================================================================

        // Initialize dark mode from server session
        function initializeDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            updateDarkModeIcons(isDark);
        }

        // Update sun/moon icons based on mode
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

        // Toggle dark mode - OPTIMIZED for instant response
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            const newIsDark = !isDark;

            // ⚡ Instant visual update (no waiting)
            if (newIsDark) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
            
            // ⚡ Update icons instantly
            updateDarkModeIcons(newIsDark);

            // ⚡ Dispatch event for charts/components instantly
            document.dispatchEvent(new CustomEvent('darkModeToggled'));

            // 🔄 Send to server in background (non-blocking)
            persistDarkModeToServer(newIsDark);
        }

        // Save dark mode preference to server (non-blocking background task)
        function persistDarkModeToServer(isDark) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            // Use sendBeacon for faster background transmission (doesn't wait for response)
            if (navigator.sendBeacon) {
                const data = new FormData();
                data.append('isDark', isDark ? '1' : '0');
                data.append('_token', csrfToken);
                
                navigator.sendBeacon('{{ route("settings.toggle-dark-mode") }}', data);
            } else {
                // Fallback: Fire and forget with fetch (no .then() or .catch())
                fetch('{{ route("settings.toggle-dark-mode") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ isDark: isDark })
                });
            }
        }

        // ============================================================================
        // SETTINGS MENU
        // ============================================================================

        function getSettingsMenuState() {
            return localStorage.getItem('settingsMenuOpen') === 'true';
        }

        function saveSettingsMenuState(isOpen) {
            localStorage.setItem('settingsMenuOpen', isOpen);
        }

        function updateSettingsMenuDisplay(isOpen) {
            const submenu = document.getElementById('settings-submenu');
            if (submenu) {
                if (isOpen) {
                    submenu.classList.remove('hidden');
                } else {
                    submenu.classList.add('hidden');
                }
            }
        }

        function initializeSettingsMenu() {
            const toggle = document.getElementById('settings-menu-toggle');
            if (!toggle) return;

            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const currentState = getSettingsMenuState();
                const newState = !currentState;
                saveSettingsMenuState(newState);
                updateSettingsMenuDisplay(newState);
            });

            // Load initial state
            updateSettingsMenuDisplay(getSettingsMenuState());
        }

        // ============================================================================
        // SIDEBAR MANAGEMENT (Mobile)
        // ============================================================================

        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar) sidebar.classList.add('open');
            if (overlay) overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar) sidebar.classList.remove('open');
            if (overlay) overlay.classList.add('hidden');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (!sidebar) return;
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        // ============================================================================
        // INITIALIZATION
        // ============================================================================

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dark mode
            initializeDarkMode();
            initializeSettingsMenu();

            // Setup sidebar toggle
            const toggle = document.getElementById('sidebar-toggle');
            if (toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleSidebar();
                });
            }

            // Close sidebar when clicking on a nav link
            const navLinks = document.querySelectorAll('aside a');
            navLinks.forEach(link => {
                link.addEventListener('click', closeSidebar);
            });

            // Auto-hide notifications after 5 seconds
            setTimeout(() => {
                const notifications = document.querySelectorAll('[id*="notification"]');
                notifications.forEach(notif => {
                    notif.style.opacity = '0';
                    notif.style.transition = 'opacity 0.3s ease-in-out';
                    setTimeout(() => notif.remove(), 300);
                });
            }, 5000);
        });
    </script>
</body>
</html>
