

<?php $__env->startSection('header', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 min-h-screen" style="background-color: var(--content-bg-color, #ffffff);">
    <!-- Clickable Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
        <a href="<?php echo e(route('assets.index')); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-green-100 dark:bg-green-900/30">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Total Assets</p>
                    <p class="text-xl font-bold" style="color: var(--text-primary-color, #00a400);"><?php echo e($totalAssets); ?></p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('assets.index', ['status' => 'deployed'])); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--blue-bg-color, #dbeafe);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--blue-text-color, #2563eb);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Deployed Assets</p>
                    <p class="text-xl font-bold" style="color: var(--blue-text-color, #2563eb);"><?php echo e($deployed); ?></p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('assets.index', ['status' => 'ready_to_deploy'])); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--blue-bg-color, #dbeafe);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--blue-text-color, #2563eb);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Ready to Deploy</p>
                    <p class="text-xl font-bold" style="color: var(--text-primary-color, #111827);"><?php echo e($readyToDeploy); ?></p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('assets.index', ['status' => 'archive'])); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--yellow-bg-color, #fef9c3);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--yellow-text-color, #ca8a04);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Archive</p>
                    <p class="text-xl font-bold" style="color: var(--text-primary-color, #111827);"><?php echo e($archive); ?></p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('assets.index', ['status' => 'broken'])); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--red-bg-color, #fee2e2);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--red-text-color, #dc2626);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Broken</p>
                    <p class="text-xl font-bold" style="color: var(--text-primary-color, #111827);"><?php echo e($broken); ?></p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('assets.index', ['status' => 'in_service'])); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--purple-bg-color, #f3e8ff);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--purple-text-color, #9333ea);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">In Service</p>
                    <p class="text-xl font-bold" style="color: var(--text-primary-color, #111827);"><?php echo e($inService); ?></p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('assets.index', ['status' => 'request_disposal'])); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--orange-bg-color, #ffedd5);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--orange-text-color, #ea580c);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Request Disposal</p>
                    <p class="text-xl font-bold" style="color: var(--text-primary-color, #111827);"><?php echo e($requestDisposal); ?></p>
                </div>
            </div>
        </a>



        <a href="<?php echo e(route('licenses.index', ['status' => 'active'])); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--indigo-bg-color, #e0e7ff);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--indigo-text-color, #4f46e5);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Active Licenses</p>
                    <p class="text-xl font-bold" style="color: var(--text-primary-color, #111827);"><?php echo e($activeLicenses); ?></p>
                </div>
            </div>
        </a>
        
        <a href="<?php echo e(route('licenses.index', ['status' => 'expired_soon'])); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--yellow-bg-color, #fef9c3);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--yellow-text-color, #ca8a04);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2M5.172 13.172a4 4 0 005.656 0L17.828 6.172a4 4 0 00-5.656-5.656L5.172 7.516a4 4 0 000 5.656z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Licenses Expiring Soon</p>
                    <p class="text-xl font-bold" style="color: var(--yellow-text-color, #ca8a04);"><?php echo e($licensesExpiredSoon); ?></p>
                </div>
            </div>
        </a>
        
        <a href="<?php echo e(route('licenses.index', ['status' => 'inactive'])); ?>" class="rounded-lg shadow p-4 hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--red-bg-color, #fee2e2);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--red-text-color, #dc2626);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v2m0 5v2M5.172 13.172a4 4 0 005.656 0L17.828 6.172a4 4 0 00-5.656-5.656L5.172 7.516a4 4 0 000 5.656z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Licenses Inactive</p>
                    <p class="text-xl font-bold" style="color: var(--red-text-color, #dc2626);"><?php echo e($licensesExpired); ?></p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('emails.index')); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--cyan-bg-color, #cff9fe);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--cyan-text-color, #0891b2);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Total Emails</p>
                    <p class="text-xl font-bold" style="color: var(--text-primary-color, #111827);"><?php echo e($totalEmails); ?></p>
                </div>
            </div>
        </a>
        
        <a href="<?php echo e(route('emails.index', ['status' => 'active'])); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--green-bg-color, #dcfce7);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--green-text-color, #16a34a);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Active Emails</p>
                    <p class="text-xl font-bold" style="color: var(--green-text-color, #16a34a);"><?php echo e($activeEmails); ?></p>
                </div>
            </div>
        </a>
        
        <a href="<?php echo e(route('emails.index', ['status' => 'not used'])); ?>" class="rounded-lg shadow p-4 border hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--gray-bg-color, #f3f4f6);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--gray-text-color, #4b5563);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5-4a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Not Used Emails</p>
                    <p class="text-xl font-bold" style="color: var(--gray-text-color, #4b5563);"><?php echo e($notUsedEmails); ?></p>
                </div>
            </div>
        </a>
        
        <a href="<?php echo e(route('emails.index', ['status' => 'inactive'])); ?>" class="rounded-lg shadow p-4 hover:shadow-lg transition-shadow cursor-pointer" style="background-color: var(--card-bg-color, #ffffff);">
            <div class="flex items-center">
                <div class="p-2 rounded-full" style="background-color: var(--red-bg-color, #fee2e2);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--red-text-color, #dc2626);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3v3h-3v-3zm0-8h3v3h-3V5zm1-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium" style="color: var(--text-secondary-color, #4b5563);">Inactive Emails</p>
                    <p class="text-xl font-bold" style="color: var(--red-text-color, #dc2626);"><?php echo e($inactiveEmails); ?></p>
                </div>
            </div>
        </a>
    </div>

    <!-- Analytics Dashboard -->
    <div class="mb-8" style="background-color: var(--card-bg-color, #ffffff);">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold" style="color: var(--text-primary-color, #111827);">Asset Analytics</h2>
            <div class="flex space-x-2">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
            </div>
        </div>
        
        <!-- Status and Department Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Asset Status Distribution -->
            <div class="rounded-xl shadow-sm p-6 border hover:shadow-md transition-shadow" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary-color, #111827);">Status Distribution</h3>
                    <div class="px-2 py-1 bg-green-100 dark:bg-green-900/30 rounded-full">
                        <span class="text-xs font-medium text-green-800 dark:text-green-200">Live</span>
                    </div>
                </div>
                <div class="h-64 flex items-center justify-center" id="status-chart-container">
                    <canvas id="assetStatusChart"></canvas>
                </div>
            </div>

            <!-- Department Distribution -->
            <div class="rounded-xl shadow-sm p-6 border hover:shadow-md transition-shadow" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary-color, #111827);">By Department</h3>
                    <div class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <span class="text-xs font-medium text-blue-800 dark:text-blue-200">Live</span>
                    </div>
                </div>
                <div class="h-64 flex items-center justify-center" id="department-chart-container">
                    <canvas id="departmentChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Trends Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Monthly Trends -->
            <div class="rounded-xl shadow-sm p-6 border hover:shadow-md transition-shadow" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary-color, #111827);">Monthly Trends</h3>
                    <div class="px-2 py-1 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                        <span class="text-xs font-medium text-purple-800 dark:text-purple-200">Live</span>
                    </div>
                </div>
                <div class="h-64 flex items-center justify-center" id="monthly-chart-container">
                    <canvas id="monthlyTrendsChart"></canvas>
                </div>
            </div>

            <!-- Damage Trends -->
            <div class="rounded-xl shadow-sm p-6 border hover:shadow-md transition-shadow" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary-color, #111827);">Damage Trends</h3>
                    <div class="px-2 py-1 bg-red-100 dark:bg-red-900/30 rounded-full">
                        <span class="text-xs font-medium text-red-800 dark:text-red-200">Live</span>
                    </div>
                </div>
                <div class="h-64 flex items-center justify-center" id="damage-chart-container">
                    <canvas id="damageTrendsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Assets -->
    <div class="rounded-lg shadow p-6 border" style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium" style="color: var(--text-primary-color, #111827);">Recent Assets</h3>
            <a href="<?php echo e(route('assets.index')); ?>" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm font-medium">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y" style="border-color: var(--border-color, #e5e7eb);">
                <thead style="background-color: var(--card-bg-color, #ffffff);">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary-color, #6b7280);">Asset Code</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary-color, #6b7280);">Model</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary-color, #6b7280);">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary-color, #6b7280);">Updated</th>
                    </tr>
                </thead>
                <tbody style="background-color: var(--card-bg-color, #ffffff); border-color: var(--border-color, #e5e7eb);">
                    <?php $__empty_1 = true; $__currentLoopData = $recentAssets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr style="background-color: var(--card-bg-color, #ffffff);" onmouseover="this.style.backgroundColor='var(--gray-bg-color, #f9fafb)'" onmouseout="this.style.backgroundColor='var(--card-bg-color, #ffffff)'">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <a href="<?php echo e(route('assets.show', $asset)); ?>" class="text-green-600 hover:text-green-900 font-medium">
                                    <?php echo e($asset->asset_code); ?>

                                </a>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm" style="color: var(--text-primary-color, #111827);">
                                <?php echo e($asset->model ?? 'N/A'); ?>

                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php switch($asset->status):
                                        case ('ready_to_deploy'): ?> bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200 <?php break; ?>
                                        <?php case ('deployed'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 <?php break; ?>
                                        <?php case ('archive'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200 <?php break; ?>
                                        <?php case ('broken'): ?> bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200 <?php break; ?>
                                        <?php case ('in_service'): ?> bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200 <?php break; ?>
                                        <?php case ('request_disposal'): ?> bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-200 <?php break; ?>
                                        <?php case ('disposal'): ?> bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 <?php break; ?>
                                    <?php endswitch; ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $asset->status))); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm" style="color: var(--text-secondary-color, #6b7280);">
                                <?php echo e($asset->updated_at->diffForHumans()); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center" style="color: var(--text-secondary-color, #6b7280);">
                                No assets found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php echo $__env->make('dashboard.charts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.authenticated', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AssetsManagement\resources\views/dashboard/index.blade.php ENDPATH**/ ?>