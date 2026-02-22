<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Read CSV file
$csvFile = 'email_data.csv';
if (!file_exists($csvFile)) {
    echo "File $csvFile not found!\n";
    exit(1);
}

// First, truncate the emails table or backup existing data
echo "Reading CSV file: $csvFile\n";

$handle = fopen($csvFile, 'r');

// Check file encoding and handle BOM
$bom = fread($handle, 3);
if ($bom !== "\xEF\xBB\xBF") {
    rewind($handle);
}

$header = fgetcsv($handle, 0, ';');

if (!$header) {
    echo "Failed to read CSV header!\n";
    exit(1);
}

echo "Header columns: " . implode(', ', $header) . "\n\n";

// Get all departments from database
$departments = DB::table('departments')->pluck('id', 'name')->toArray();

$rowCount = 0;
$imported = 0;
$skipped = 0;
$errors = [];

while (($row = fgetcsv($handle, 0, ';')) !== FALSE) {
    $rowCount++;
    
    if (count($row) < 7) {
        echo "Row $rowCount: Insufficient columns (got " . count($row) . ")\n";
        continue;
    }
    
    $data = array_combine($header, $row);
    
    // Clean up data
    $email = trim($data['email'] ?? '');
    $name = trim($data['name'] ?? '');
    $position = trim($data['position'] ?? '');
    $departmentName = trim($data['department'] ?? '');
    $status = strtolower(trim($data['status'] ?? 'active'));
    $description = trim($data['description'] ?? '');
    $is_active = (int)(trim($data['is_active'] ?? '1'));
    
    if (empty($email)) {
        echo "Row $rowCount: Empty email\n";
        continue;
    }
    
    // Normalize status
    if ($status === 'active') {
        $status = 'active';
    } elseif ($status === 'not used' || $status === 'inactive') {
        $status = 'not used';
    } else {
        $status = 'active';
    }
    
    // Check if email already exists
    if (DB::table('emails')->where('email', $email)->exists()) {
        $skipped++;
        continue;
    }
    
    // Get department ID
    $departmentId = $departments[$departmentName] ?? null;
    
    if (!$departmentId && !empty($departmentName)) {
        // Create department if it doesn't exist
        $departmentId = DB::table('departments')->insertGetId([
            'name' => $departmentName,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $departments[$departmentName] = $departmentId;
        echo "📝 Created department: $departmentName\n";
    }
    
    // Insert email
    try {
        DB::table('emails')->insert([
            'email' => $email,
            'name' => $name,
            'position' => $position,
            'department_id' => $departmentId,
            'status' => $status,
            'description' => $description,
            'is_active' => $is_active,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        $imported++;
        echo "✓ Row $rowCount: $name ($email)\n";
    } catch (\Exception $e) {
        $skipped++;
        $errors[] = "Row $rowCount - $email: " . $e->getMessage();
        echo "✗ Row $rowCount: Error - " . $e->getMessage() . "\n";
    }
}

fclose($handle);

echo "\n" . str_repeat("=", 70) . "\n";
echo "Import Summary:\n";
echo "  Total rows processed: $rowCount\n";
echo "  ✓ Successfully imported: $imported\n";
echo "  ⊘ Skipped (already exists): $skipped\n";

if (!empty($errors)) {
    echo "\nErrors encountered:\n";
    foreach ($errors as $error) {
        echo "  - $error\n";
    }
}

// Final verification
$totalEmails = DB::table('emails')->count();
$activeEmails = DB::table('emails')->where('status', 'active')->count();
$notUsedEmails = DB::table('emails')->where('status', 'not used')->count();

echo "\nDatabase Status:\n";
echo "  Total emails in database: $totalEmails\n";
echo "  Active status: $activeEmails\n";
echo "  Not Used status: $notUsedEmails\n";

echo "\nDone!\n";
