<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$today = \Carbon\Carbon::today();
$expiredSoon = \App\Models\License::where('status', 'active')->whereDate('expiry_date', '>=', $today)->whereDate('expiry_date', '<=', $today->addDays(30))->count();
$expired = \App\Models\License::where('status', 'active')->whereDate('expiry_date', '<', $today)->count();
$active = \App\Models\License::where('status', 'active')->count();

echo "Active Licenses: " . $active . "\n";
echo "Licenses Expiring Soon: " . $expiredSoon . "\n";
echo "Licenses Expired: " . $expired . "\n";

// Show the actual license data
echo "\n--- License Details ---\n";
$licenses = \App\Models\License::where('status', 'active')->get();
foreach ($licenses as $license) {
    echo "ID: " . $license->id . ", Software: " . $license->software_name . ", Expiry: " . $license->expiry_date . ", Days: " . $license->expiry_date->diffInDays(\Carbon\Carbon::today()) . "\n";
}
