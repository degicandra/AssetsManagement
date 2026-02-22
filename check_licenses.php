<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\License;
use Carbon\Carbon;

echo "License statuses: ";
print_r(License::select('status')->distinct()->pluck('status')->toArray());

echo "\nLicenses with status 'active': " . License::where('status', 'active')->count() . "\n";

echo "\nLicenses expiring soon (30 days): " . License::where('status', 'active')
    ->whereDate('expiry_date', '>=', Carbon::today())
    ->whereDate('expiry_date', '<=', Carbon::today()->addDays(30))
    ->count() . "\n";

echo "\nLicenses already expired: " . License::where('status', 'active')
    ->whereDate('expiry_date', '<', Carbon::today())
    ->count() . "\n";

echo "\nSample licenses:\n";
$licenses = License::limit(10)->get();
foreach($licenses as $license) {
    echo "ID: {$license->id}, Status: {$license->status}, Expiry: " . 
         ($license->expiry_date ? $license->expiry_date->format('Y-m-d') : 'NULL') . 
         ", Days: " . ($license->expiry_date ? Carbon::today()->diffInDays($license->expiry_date, false) : 'N/A') . "\n";
}