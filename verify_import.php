<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

$assets = \App\Models\Asset::whereIn('asset_code', [
    'BMHS00000579',
    'BMHS00001815', 
    'BMHS00008712',
    'BMHS00010112'
])->get(['asset_code', 'status', 'person_in_charge']);

echo "Verification Results:\n";
echo str_repeat("=", 50) . "\n";
foreach ($assets as $asset) {
    echo "Asset: {$asset->asset_code}\n";
    echo "  Status: {$asset->status}\n";
    echo "  Person: {$asset->person_in_charge}\n";
}
echo str_repeat("=", 50) . "\n";
echo "Total imported: " . $assets->count() . " of 4\n";
