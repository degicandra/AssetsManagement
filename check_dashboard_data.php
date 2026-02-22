<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Asset;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

echo "=== DASHBOARD DATA CHECK ===\n\n";

echo "Asset Status Counts:\n";
echo "Total Assets: " . Asset::count() . "\n";
echo "Deployed: " . Asset::where('status', 'deployed')->count() . "\n";
echo "Ready to Deploy: " . Asset::where('status', 'ready_to_deploy')->count() . "\n";
echo "Archive: " . Asset::where('status', 'archive')->count() . "\n";
echo "Broken: " . Asset::where('status', 'broken')->count() . "\n";
echo "In Service: " . Asset::where('status', 'service')->count() . "\n";
echo "Request Disposal: " . Asset::where('status', 'request_disposal')->count() . "\n";
echo "Disposed: " . Asset::where('status', 'disposed')->count() . "\n\n";

echo "Department Distribution:\n";
$deptData = DB::table('assets')
    ->join('departments', 'assets.department_id', '=', 'departments.id')
    ->select('departments.name', DB::raw('COUNT(assets.id) as count'))
    ->groupBy('departments.id', 'departments.name')
    ->orderBy('count', 'desc')
    ->get();

foreach($deptData as $dept) {
    echo "{$dept->name}: {$dept->count}\n";
}

echo "\nMonthly Asset Trends (2026):\n";
$monthlyData = [];
for($month = 1; $month <= 12; $month++) {
    $count = Asset::whereYear('created_at', 2026)
        ->whereMonth('created_at', $month)
        ->count();
    $monthName = date('M', mktime(0, 0, 0, $month, 1));
    echo "$monthName: $count\n";
    $monthlyData[] = $count;
}

echo "\nMonthly Broken Assets (2026):\n";
$brokenData = [];
for($month = 1; $month <= 12; $month++) {
    $count = Asset::where('status', 'broken')
        ->whereYear('created_at', 2026)
        ->whereMonth('created_at', $month)
        ->count();
    $monthName = date('M', mktime(0, 0, 0, $month, 1));
    echo "$monthName: $count\n";
    $brokenData[] = $count;
}

echo "\nJSON Data for charts:\n";
echo "Monthly Assets Trend: " . json_encode($monthlyData) . "\n";
echo "Monthly Broken Trend: " . json_encode($brokenData) . "\n";