

<?php $__env->startSection('header', 'Add New Asset'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
        <form action="<?php echo e(route('assets.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-200">Add New Asset</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Create a new asset record with core details and optional specifications.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Company -->
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Company *
                    </label>
                          <input type="text" name="company" id="company" value="<?php echo e(old('company')); ?>" required
                              class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <?php $__errorArgs = ['company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Asset Code -->
                <div>
                    <label for="asset_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Asset Code *
                    </label>
                          <input type="text" name="asset_code" id="asset_code" value="<?php echo e(old('asset_code')); ?>" required
                              class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <?php $__errorArgs = ['asset_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Serial Number -->
                <div>
                    <label for="serial_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Serial Number
                    </label>
                          <input type="text" name="serial_number" id="serial_number" value="<?php echo e(old('serial_number')); ?>"
                              class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Model -->
                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Model *
                    </label>
                          <input type="text" name="model" id="model" value="<?php echo e(old('model')); ?>" required
                              class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Type -->
                <div>
                    <label for="type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Type *
                    </label>
                    <select name="type_id" id="type_id" required
                        class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">-- Select Type --</option>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>" <?php echo e(old('type_id') == $type->id ? 'selected' : ''); ?>>
                                <?php echo e($type->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Brand *
                    </label>
                          <input type="text" name="brand" id="brand" value="<?php echo e(old('brand')); ?>" required
                              class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Status *
                    </label>
                        <select name="status" id="status" required
                            class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Select Status</option>
                        <option value="ready_to_deploy" <?php echo e(old('status') == 'ready_to_deploy' ? 'selected' : ''); ?>>Ready to Deploy</option>
                        <option value="deployed" <?php echo e(old('status') == 'deployed' ? 'selected' : ''); ?>>Deployed</option>
                        <option value="archive" <?php echo e(old('status') == 'archive' ? 'selected' : ''); ?>>Archive</option>
                        <option value="broken" <?php echo e(old('status') == 'broken' ? 'selected' : ''); ?>>Broken</option>
                        <option value="service" <?php echo e(old('status') == 'service' ? 'selected' : ''); ?>>Service</option>
                        <option value="request_disposal" <?php echo e(old('status') == 'request_disposal' ? 'selected' : ''); ?>>Request Disposal</option>
                        <option value="disposed" <?php echo e(old('status') == 'disposed' ? 'selected' : ''); ?>>Disposed</option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Department -->
                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Department *
                    </label>
                        <select name="department_id" id="department_id" required
                            class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Select Department</option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($department->id); ?>" <?php echo e(old('department_id') == $department->id ? 'selected' : ''); ?>>
                                <?php echo e($department->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['department_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Floor -->
                <div>
                    <label for="floor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Floor *
                    </label>
                        <select name="floor_id" id="floor_id" required
                            class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Select Floor</option>
                        <?php $__currentLoopData = $floors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $floor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($floor->id); ?>" <?php echo e(old('floor_id') == $floor->id ? 'selected' : ''); ?>>
                                <?php echo e($floor->name); ?> (<?php echo e($floor->floor_number); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label for="location_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Location *
                    </label>
                        <select name="location_id" id="location_id" required
                            class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Select Location</option>
                        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($location->id); ?>" 
                                    data-floor="<?php echo e($location->floor_id); ?>"
                                    <?php echo e(old('location_id') == $location->id ? 'selected' : ''); ?>>
                                <?php echo e($location->name); ?> (<?php echo e($location->floor->name ?? 'No Floor'); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['location_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Person In Charge -->
                <div>
                    <label for="person_in_charge" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Person In Charge *
                    </label>
                          <input type="text" name="person_in_charge" id="person_in_charge" value="<?php echo e(old('person_in_charge')); ?>" required
                              class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <?php $__errorArgs = ['person_in_charge'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Purchase Date -->
                <div>
                    <label for="purchase_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Purchase Date *
                    </label>
                          <input type="date" name="purchase_date" id="purchase_date" value="<?php echo e(old('purchase_date')); ?>" required
                              class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <?php $__errorArgs = ['purchase_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Warranty Expiration -->
                <div>
                    <label for="warranty_expiration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Warranty Expiration
                    </label>
                          <input type="date" name="warranty_expiration" id="warranty_expiration" value="<?php echo e(old('warranty_expiration')); ?>"
                              class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <!-- Optional Specifications -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">Optional Specifications</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Processor -->
                    <div>
                        <label for="processor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Processor
                        </label>
                           <input type="text" name="processor" id="processor" value="<?php echo e(old('processor')); ?>"
                               class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                               placeholder="e.g., Intel i7-10700">
                    </div>

                    <!-- Storage Type -->
                    <div>
                        <label for="storage_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Storage Type
                        </label>
                        <select name="storage_type" id="storage_type"
                            class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Select Storage Type</option>
                            <option value="HDD" <?php echo e(old('storage_type') == 'HDD' ? 'selected' : ''); ?>>HDD</option>
                            <option value="SSD" <?php echo e(old('storage_type') == 'SSD' ? 'selected' : ''); ?>>SSD</option>
                        </select>
                    </div>

                    <!-- Storage Size -->
                    <div>
                        <label for="storage_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Storage Size
                        </label>
                           <input type="text" name="storage_size" id="storage_size" value="<?php echo e(old('storage_size')); ?>"
                               class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                               placeholder="e.g., 512GB, 1TB">
                    </div>

                    <!-- RAM -->
                    <div>
                        <label for="ram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            RAM
                        </label>
                           <input type="text" name="ram" id="ram" value="<?php echo e(old('ram')); ?>"
                               class="w-full rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                               placeholder="e.g., 16GB, 32GB">
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Asset Image
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-lg">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                            <label for="image" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-green-600 hover:text-green-500">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            PNG, JPG, GIF up to 2MB
                        </p>
                    </div>
                </div>
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Notes
                </label>
                <textarea name="notes" id="notes" rows="4"
                          class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 shadow-sm focus:border-green-500 focus:ring-green-500"><?php echo e(old('notes')); ?></textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="<?php echo e(route('assets.index')); ?>" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 text-sm font-bold text-white bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 active:bg-green-700 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    Create Asset
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Location filtering based on floor selection
    document.getElementById('floor_id').addEventListener('change', function() {
        const floorId = this.value;
        const locationSelect = document.getElementById('location_id');
        const options = locationSelect.querySelectorAll('option[data-floor]');
        
        // Reset location selection
        locationSelect.value = '';
        
        // Show/hide locations based on floor
        options.forEach(option => {
            if (floorId === '' || option.dataset.floor === floorId) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
    });

    // Trigger change event on page load to set initial state
    document.getElementById('floor_id').dispatchEvent(new Event('change'));
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.authenticated', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AssetsManagement\resources\views/assets/create.blade.php ENDPATH**/ ?>