<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Asset;
use App\Models\Department;
use App\Models\Location;
use App\Models\AssetType;

// Read CSV file
$csvFile = __DIR__ . '/asset_import_template.csv';
$file = fopen($csvFile, 'r');

// Detect delimiter
$firstLine = fgets($file);
$delimiter = strpos($firstLine, ';') !== false ? ';' : ',';
rewind($file);

// Parse header
$header = fgetcsv($file, 0, $delimiter);
$header = array_map('trim', $header);

// Create lookup arrays for fuzzy matching
$departments = Department::all()->pluck('name', 'id')->toArray();
$locations = Location::all()->pluck('name', 'id')->toArray();
$types = AssetType::all()->pluck('name', 'id')->toArray();

// Helper function for fuzzy matching
function fuzzyMatch($search, $options) {
    $search = strtolower(trim($search));
    foreach ($options as $id => $name) {
        if (strtolower($name) === $search || stripos($name, $search) !== false) {
            return $id;
        }
    }
    return null;
}

// Parse data rows
$imported = 0;
$failed = 0;
$rowNum = 1;
$assetCodeCounter = 1000; // Start counter for generated asset codes

echo "Starting RSIA Bunda Jakarta Asset Import\n";
echo str_repeat("=", 60) . "\n";

while (($row = fgetcsv($file, 0, $delimiter)) !== false) {
    $rowNum++;
    if (empty(array_filter($row))) continue;
    
    $data = array_combine($header, $row);
    $data = array_map('trim', $data);
    
    try {
        // Get or create Department
        $deptName = trim($data['Department'] ?? '');
        $dept_id = fuzzyMatch($deptName, $departments);
        if (!$dept_id) {
            $dept = Department::create(['name' => $deptName]);
            $dept_id = $dept->id;
            $departments[$dept_id] = $deptName;
        }
        
        // Get or create Location
        $locName = trim($data['Location'] ?? '');
        $loc_id = fuzzyMatch($locName, $locations);
        if (!$loc_id) {
            $loc = Location::create(['name' => $locName]);
            $loc_id = $loc->id;
            $locations[$loc_id] = $locName;
        }
        
        // Get or create AssetType
        $typeName = trim($data['Type'] ?? '');
        $type_id = fuzzyMatch($typeName, $types);
        if (!$type_id) {
            $type = AssetType::create(['name' => $typeName]);
            $type_id = $type->id;
            $types[$type_id] = $typeName;
        }
        
        // Generate or use asset code
        $assetCode = trim($data['Asset Code'] ?? '');
        if (empty($assetCode) || $assetCode === '-') {
            // Generate a unique asset code using company initials + counter
            $assetCode = 'RSB' . str_pad($assetCodeCounter++, 6, '0', STR_PAD_LEFT);
        }
        
        // Parse dates (DD/MM/YYYY format)
        $purchaseDate = null;
        if (!empty($data['Purchase Date (YYYY-MM-DD)'])) {
            $dateStr = trim($data['Purchase Date (YYYY-MM-DD)']);
            if (preg_match('/(\d{2})\/(\d{2})\/(\d{4})/', $dateStr, $matches)) {
                $purchaseDate = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
            } elseif (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $dateStr)) {
                $purchaseDate = $dateStr;
            }
        }
        
        $warrantyDate = null;
        if (!empty($data['Warranty Expiration (YYYY-MM-DD)'])) {
            $dateStr = trim($data['Warranty Expiration (YYYY-MM-DD)']);
            if (preg_match('/(\d{2})\/(\d{2})\/(\d{4})/', $dateStr, $matches)) {
                $warrantyDate = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
            } elseif (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $dateStr)) {
                $warrantyDate = $dateStr;
            }
        }
        
        // Parse storage size (e.g., "120GB" -> 120)
        $storageSize = null;
        if (!empty($data['Storage Size'])) {
            preg_match('/(\d+)/', trim($data['Storage Size']), $matches);
            $storageSize = isset($matches[1]) ? (int)$matches[1] : null;
        }
        
        // Parse RAM (e.g., "8GB" -> 8)
        $ram = null;
        if (!empty($data['RAM'])) {
            preg_match('/(\d+)/', trim($data['RAM']), $matches);
            $ram = isset($matches[1]) ? (int)$matches[1] : null;
        }
        
        // Parse storage type
        $storageType = trim($data['Storage Type'] ?? 'SSD');
        if (!in_array($storageType, ['HDD', 'SSD'])) {
            $storageType = 'SSD';
        }
        
        // Create asset
        $asset = Asset::create([
            'company' => trim($data['Company'] ?? 'RSIA Bunda Jakarta'),
            'asset_code' => $assetCode,
            'serial_number' => !empty($data['Serial Number']) && $data['Serial Number'] !== '-' 
                ? trim($data['Serial Number']) 
                : null,
            'model' => trim($data['Model'] ?? ''),
            'brand' => trim($data['Brand'] ?? ''),
            'status' => 'deployed', // "active" -> "deployed"
            'location_id' => $loc_id,
            'department_id' => $dept_id,
            'type_id' => $type_id,
            'person_in_charge' => trim($data['Person In Charge'] ?? ''),
            'purchase_date' => $purchaseDate,
            'warranty_expiration' => $warrantyDate,
            'processor' => trim($data['Processor'] ?? ''),
            'storage_type' => $storageType,
            'storage_size' => $storageSize,
            'ram' => $ram,
            'specification_upgraded' => isset($data['Specification Upgraded (0/1)']) && trim($data['Specification Upgraded (0/1)']) === '1' ? 1 : 0,
            'notes' => trim($data['Notes'] ?? ''),
        ]);
        
        echo "✓ Row $rowNum: {$assetCode} - {$asset->model} ({$typeName})\n";
        $imported++;
        
    } catch (Exception $e) {
        echo "✗ Row $rowNum: " . $e->getMessage() . "\n";
        $failed++;
    }
}

fclose($file);

echo "\n" . str_repeat("=", 60) . "\n";
echo "Import Summary:\n";
echo "Total Imported: $imported\n";
echo "Failed: $failed\n";
echo str_repeat("=", 60) . "\n";
