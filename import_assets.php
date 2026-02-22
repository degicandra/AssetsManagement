<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Department;
use App\Models\Location;

// Asset data from the CSV file
$assetData = [
    [
        'company' => 'RSIA Bunda Jakarta',
        'asset_code' => 'BMHS00000579',
        'serial_number' => null,
        'model' => 'Rakitan core2duo',
        'brand' => 'Simbada',
        'type' => 'PC Desktop',
        'status' => 'deployed',
        'location' => 'Apotek Central / Farmasi Rawat Jalan',
        'department' => 'Pharmacy',
        'person_in_charge' => 'ANGGI ISNAASAR',
        'purchase_date' => '2016-01-15',
        'warranty_expiration' => '2016-01-15',
        'processor' => 'Intel Core 2 Duo',
        'storage_type' => 'SSD',
        'storage_size' => '120GB',
        'ram' => '4GB',
        'specification_upgraded' => 0,
        'notes' => 'Butuh Pergantian',
        'is_active' => 1,
    ],
    [
        'company' => 'RSIA Bunda Jakarta',
        'asset_code' => 'BMHS00001815',
        'serial_number' => null,
        'model' => 'Lenovo core i3 gen4',
        'brand' => 'Lenovo',
        'type' => 'PC Desktop',
        'status' => 'deployed',
        'location' => 'Apotek Central / Farmasi Rawat Jalan',
        'department' => 'Pharmacy',
        'person_in_charge' => 'ANGGI ISNAASAR',
        'purchase_date' => '2016-01-15',
        'warranty_expiration' => '2016-01-15',
        'processor' => 'Intel Core i3 gen4',
        'storage_type' => 'SSD',
        'storage_size' => '120GB',
        'ram' => '4GB',
        'specification_upgraded' => 0,
        'notes' => 'Butuh Pergantian',
        'is_active' => 1,
    ],
    [
        'company' => 'RSIA Bunda Jakarta',
        'asset_code' => 'BMHS00008712',
        'serial_number' => null,
        'model' => 'Rakitan core i3 gen3',
        'brand' => 'Simbada',
        'type' => 'PC Desktop',
        'status' => 'deployed',
        'location' => 'Apotek Central / Farmasi Rawat Jalan',
        'department' => 'Pharmacy',
        'person_in_charge' => 'ANGGI ISNAASAR',
        'purchase_date' => '2016-01-15',
        'warranty_expiration' => '2016-01-15',
        'processor' => 'Intel Core i3 gen3',
        'storage_type' => 'SSD',
        'storage_size' => '120GB',
        'ram' => '4GB',
        'specification_upgraded' => 0,
        'notes' => 'Butuh Pergantian',
        'is_active' => 1,
    ],
    [
        'company' => 'RSIA Bunda Jakarta',
        'asset_code' => 'BMHS00010112',
        'serial_number' => null,
        'model' => 'Rakitan core i3 gen3',
        'brand' => 'Simbada',
        'type' => 'PC Desktop',
        'status' => 'deployed',
        'location' => 'Apotek Central / Farmasi Rawat Jalan',
        'department' => 'Pharmacy',
        'person_in_charge' => 'ANGGI ISNAASAR',
        'purchase_date' => '2016-01-15',
        'warranty_expiration' => '2016-01-15',
        'processor' => 'Intel Core i3 gen3',
        'storage_type' => 'SSD',
        'storage_size' => '120GB',
        'ram' => '4GB',
        'specification_upgraded' => 0,
        'notes' => 'Butuh Pergantian',
        'is_active' => 1,
    ],
];

$imported = 0;
$errors = [];

foreach ($assetData as $index => $data) {
    try {
        // Get IDs for relationships
        $typeId = AssetType::where('name', 'like', "%{$data['type']}%")->first()?->id;
        $departmentId = Department::where('name', 'like', "%{$data['department']}%")->first()?->id;
        $locationId = Location::where('name', 'like', "%{$data['location']}%")->first()?->id;

        // Validate required fields
        if (empty($data['asset_code'])) {
            throw new Exception('Asset code is required');
        }

        // Check if asset already exists
        if (Asset::where('asset_code', $data['asset_code'])->exists()) {
            echo "⚠ Row " . ($index + 1) . ": Asset code {$data['asset_code']} already exists, skipping\n";
            continue;
        }

        // Create asset
        Asset::create([
            'company' => $data['company'],
            'asset_code' => $data['asset_code'],
            'serial_number' => $data['serial_number'],
            'model' => $data['model'],
            'brand' => $data['brand'],
            'type_id' => $typeId,
            'status' => $data['status'],
            'location_id' => $locationId,
            'department_id' => $departmentId,
            'person_in_charge' => $data['person_in_charge'],
            'purchase_date' => $data['purchase_date'],
            'warranty_expiration' => $data['warranty_expiration'],
            'processor' => $data['processor'],
            'storage_type' => $data['storage_type'],
            'storage_size' => $data['storage_size'],
            'ram' => $data['ram'],
            'specification_upgraded' => $data['specification_upgraded'],
            'notes' => $data['notes'],
            'is_active' => $data['is_active'],
        ]);

        echo "✓ Row " . ($index + 1) . ": Asset {$data['asset_code']} imported successfully\n";
        $imported++;
    } catch (Exception $e) {
        $errors[] = "Row " . ($index + 1) . ": " . $e->getMessage();
        echo "✗ Row " . ($index + 1) . ": " . $e->getMessage() . "\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "Import Summary:\n";
echo "Total Imported: $imported\n";
if (!empty($errors)) {
    echo "Total Errors: " . count($errors) . "\n";
    echo "\nError Details:\n";
    foreach ($errors as $error) {
        echo "  - $error\n";
    }
}
echo str_repeat("=", 60) . "\n";
