<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="<?php echo e(session('theme', 'light') === 'dark' ? 'dark' : ''); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Assets Management')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

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
    <?php echo $__env->yieldContent('content'); ?>

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
                
                navigator.sendBeacon('<?php echo e(route("settings.toggle-dark-mode")); ?>', data);
            } else {
                // Fallback: Fire and forget with fetch (no .then() or .catch())
                fetch('<?php echo e(route("settings.toggle-dark-mode")); ?>', {
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
<?php /**PATH C:\xampp\htdocs\AssetsManagement\resources\views/layouts/app.blade.php ENDPATH**/ ?>