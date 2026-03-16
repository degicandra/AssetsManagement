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

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Layout-only CSS (Dark mode styles are in darkmode.css) */
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }

        .min-h-screen {
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    @yield('content')

    <script>
        // Initialize dark mode from server session
        function initializeDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            updateDarkModeIcons(isDark);
        }

        // Update sun/moon icons
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

            // 🔄 Send to server in background (non-blocking)
            persistDarkModeToServer(newIsDark);
        }

        // Save preference to server (non-blocking background task)
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

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeDarkMode();
        });
    </script>
</body>
</html>
