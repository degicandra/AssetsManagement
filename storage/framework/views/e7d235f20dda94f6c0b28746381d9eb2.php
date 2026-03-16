

<?php $__env->startSection('header', 'Asset Request Details'); ?>

<?php $__env->startSection('content'); ?>
<style>
    @keyframes pulse-ring {
        0% {
            box-shadow: 0 0 0 0 currentColor;
        }
        70% {
            box-shadow: 0 0 0 8px rgba(34, 197, 94, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
        }
    }
    .animate-pulse-ring {
        animation: pulse-ring 1.5s infinite;
        color: rgb(34, 197, 94);
    }
</style>
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            <?php echo e($assetRequest->title); ?>

                        </h1>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            <?php switch($assetRequest->status):
                                case ('request_created'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200 <?php break; ?>
                                <?php case ('finance_approval'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200 <?php break; ?>
                                <?php case ('director_approval'): ?> bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200 <?php break; ?>
                                <?php case ('submitted_purchasing'): ?> bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-200 <?php break; ?>
                                <?php case ('item_purchased'): ?> bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200 <?php break; ?>
                            <?php endswitch; ?>">
                            <?php echo e($assetRequest->status_display); ?>

                        </span>
                    </div>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Created on <?php echo e($assetRequest->created_at->format('d M Y H:i')); ?>

                    </p>
                </div>
                <div class="flex flex-wrap gap-2 items-center">
                    <a href="<?php echo e(route('asset-requests.edit', $assetRequest)); ?>" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-md font-medium flex items-center transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form action="<?php echo e(route('asset-requests.destroy', $assetRequest)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-md font-medium flex items-center transition-colors duration-200"
                                onclick="return confirm('Are you sure you want to delete this request?')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                    <?php if($assetRequest->status === 'item_purchased'): ?>
                        <form action="<?php echo e(route('asset-requests.convert-to-asset', $assetRequest)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" 
                                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-800 text-white rounded-md font-medium flex items-center transition-colors duration-200"
                                    onclick="return confirm('Convert this request to an asset?')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Convert to Asset
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
            <!-- Main Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Item Description -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Item Description</h2>
                    <div class="text-sm text-gray-900 dark:text-white text-left break-words">
                        <?php echo e($assetRequest->item_description); ?>

                    </div>
                </div>

                <!-- Basic Information -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Department</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($assetRequest->department->name); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Floor</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <?php if($assetRequest->floor): ?>
                                    <?php echo e($assetRequest->floor->name); ?>

                                <?php else: ?>
                                    <span class="text-gray-500">-</span>
                                <?php endif; ?>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <?php if($assetRequest->location): ?>
                                    <?php echo e($assetRequest->location->name); ?>

                                <?php else: ?>
                                    <span class="text-gray-500">-</span>
                                <?php endif; ?>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Requested By</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($assetRequest->requested_by); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Request Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($assetRequest->request_date->format('d M Y')); ?></dd>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <?php if($assetRequest->notes): ?>
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Notes</h2>
                    <div class="text-sm text-gray-900 dark:text-white text-left break-words">
                        <?php echo e($assetRequest->notes); ?>

                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar: History & Actions -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status History -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status History</h2>
                    
                    <?php if($assetRequest->histories->count() > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $assetRequest->histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex gap-3">
                                    <!-- Timeline dot and line -->
                                    <div class="flex flex-col items-center">
                                        <?php if($loop->first): ?>
                                            <div class="flex items-center justify-center w-6 h-6 animate-pulse-ring rounded-full">
                                                <div class="w-3 h-3 rounded-full <?php echo e($history->status_badge_class); ?>"></div>
                                            </div>
                                        <?php else: ?>
                                            <div class="w-3 h-3 rounded-full mt-1 <?php echo e($history->status_badge_class); ?>"></div>
                                        <?php endif; ?>
                                        <?php if(!$loop->last): ?>
                                            <div class="w-0.5 bg-gray-200 dark:bg-gray-600" style="height: 50px;"></div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 pb-2">
                                        <p class="font-medium text-sm text-gray-900 dark:text-gray-200">
                                            <?php echo e($history->new_status_display); ?>

                                        </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <?php echo e($history->changed_at->format('d M Y H:i')); ?>

                                        </p>
                                        <?php if($history->notes): ?>
                                            <p class="text-xs text-gray-700 dark:text-gray-300 mt-1"><?php echo e($history->notes); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">No history available</p>
                    <?php endif; ?>
                </div>

                <!-- Back Button -->
                <div>
                    <a href="<?php echo e(route('asset-requests.index')); ?>" 
                       class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-gray-200 rounded-md font-medium hover:bg-gray-300 dark:hover:bg-gray-700 flex items-center justify-center transition-colors duration-200">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.authenticated', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AssetsManagement\resources\views/asset-requests/show.blade.php ENDPATH**/ ?>