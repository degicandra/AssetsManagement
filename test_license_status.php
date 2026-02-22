<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\License;
use Carbon\Carbon;

echo "=== BEFORE STATUS UPDATE ===\n";
$licenses = License::all();
foreach($licenses as $license) {
    echo "ID: {$license->id}, Software: {$license->software_name}, Status: {$license->status}, Expiry: " . 
         ($license->expiry_date ? $license->expiry_date->format('Y-m-d') : 'NULL') . "\n";
}

echo "\n=== TESTING OBSERVER ===\n";
// Force the observer to run by touching each license
foreach($licenses as $license) {
    $license->touch(); // This will trigger the observer
}

echo "\n=== AFTER STATUS UPDATE ===\n";
$licenses = License::all();
foreach($licenses as $license) {
    echo "ID: {$license->id}, Software: {$license->software_name}, Status: {$license->status}, Expiry: " . 
         ($license->expiry_date ? $license->expiry_date->format('Y-m-d') : 'NULL') . "\n";
}