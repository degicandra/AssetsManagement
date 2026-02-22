<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=assets_management', 'root', '');
    
    // Count RSIA Bunda Jakarta assets
    $result = $pdo->query('SELECT COUNT(*) as total FROM assets WHERE company = "RSIA Bunda Jakarta"');
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    echo "Verification Results:\n";
    echo str_repeat("=", 60) . "\n";
    echo "Total RSIA Bunda Jakarta Assets: " . $row['total'] . " of 13\n\n";
    
    // Show sample assets
    echo "Sample Assets:\n";
    $result = $pdo->query('SELECT asset_code, model, brand, status FROM assets WHERE company = "RSIA Bunda Jakarta" ORDER BY id DESC LIMIT 5');
    
    foreach ($result as $r) {
        echo "  • " . $r['asset_code'] . " - " . $r['model'] . " (" . $r['brand'] . ") [" . $r['status'] . "]\n";
    }
    
    echo "\n" . str_repeat("=", 60) . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
