

<?php $__env->startSection('header', 'Email Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
        <!-- Email Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-200">
                        <?php echo e($email->email); ?>

                    </h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        <?php echo e($email->name); ?>

                    </p>
                </div>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('emails.edit', $email)); ?>" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-md font-medium flex items-center transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form action="<?php echo e(route('emails.destroy', $email)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-md font-medium flex items-center transition-colors duration-200"
                                onclick="return confirm('Are you sure you want to delete this email?')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
            <!-- Main Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100 mb-4">Email Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100"><?php echo e($email->email); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100"><?php echo e($email->name); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Position</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100"><?php echo e($email->position ?? 'N/A'); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-700 dark:text-gray-100">Department</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100"><?php echo e($email->department->name ?? 'N/A'); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php switch($email->status):
                                        case ('active'): ?> bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200 <?php break; ?>
                                        <?php case ('inactive'): ?> bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200 <?php break; ?>
                                        <?php case ('not used'): ?> bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-200 <?php break; ?>
                                    <?php endswitch; ?>">
                                    <?php echo e($email->status == 'not used' ? 'Not Used' : ucfirst($email->status)); ?>

                                </span>
                            </dd>
                        </div>
                        <?php if($email->description): ?>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-300">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap"><?php echo e($email->description); ?></dd>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- History -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">History</h2>
                    <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $email->histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border-l-4 border-green-500 pl-4 py-2">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $history->action_type))); ?>

                                </div>
                                <?php if($history->field_name): ?>
                                    <div class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                                        <?php echo e($history->field_name); ?>: 
                                        <?php if($history->old_value): ?>
                                            <span class="line-through"><?php echo e($history->old_value); ?></span> → 
                                        <?php endif; ?>
                                        <?php echo e($history->new_value); ?>

                                    </div>
                                <?php endif; ?>
                                <?php if($history->description): ?>
                                    <div class="text-xs text-gray-500 dark:text-gray-300 mt-1">
                                        <?php echo e($history->description); ?>

                                    </div>
                                <?php endif; ?>
                                <div class="text-xs text-gray-400 dark:text-gray-400 mt-1">
                                    <?php echo e($history->created_at->format('M d, Y H:i')); ?> by <?php echo e($history->user->name); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-gray-500 dark:text-gray-300">No history records found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.authenticated', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AssetsManagement\resources\views/emails/show.blade.php ENDPATH**/ ?>