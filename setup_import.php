<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Department;
use App\Models\Location;
use App\Models\AssetType;

// Create Department if not exists
$dept = Department::firstOrCreate(
    ['name' => 'Pharmacy'],
    ['description' => 'Apotek Central / Farmasi Rawat Jalan', 'is_active' => 1]
);
echo "✓ Department: {$dept->name}\n";

// Create Location if not exists
$location = Location::firstOrCreate(
    ['name' => 'Apotek Central / Farmasi Rawat Jalan'],
    ['description' => 'Apotek Central / Farmasi Rawat Jalan', 'floor_id' => null]
);
echo "✓ Location: {$location->name}\n";

// Create AssetType if not exists
$type = AssetType::firstOrCreate(
    ['name' => 'PC Desktop'],
    ['description' => 'Desktop Personal Computer']
);
echo "✓ AssetType: {$type->name}\n";

echo "\nSetup completed! Ready for import.\n";
