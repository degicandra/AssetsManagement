<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$count = DB::table('emails')->count();
$notUsed = DB::table('emails')->where('status', 'not used')->count();
$active = DB::table('emails')->where('status', 'active')->count();

echo "=== Email Data Summary ===\n";
echo "Total emails: $count\n";
echo "Active status: $active\n";
echo "Not Used status: $notUsed\n\n";

echo "Sample records:\n";
$emails = DB::table('emails')
    ->select('id', 'email', 'name', 'position', 'status')
    ->limit(10)
    ->get();

foreach ($emails as $e) {
    echo "  {$e->id}. {$e->name} ({$e->email})\n";
    echo "     Position: {$e->position}\n";
    echo "     Status: {$e->status}\n\n";
}
