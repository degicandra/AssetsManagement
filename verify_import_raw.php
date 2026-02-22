<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=assets_management', 'root', '');
    
    $codes = ['BMHS00000579', 'BMHS00001815', 'BMHS00008712', 'BMHS00010112'];
    $placeholders = implode(',', array_fill(0, count($codes), '?'));
    
    $stmt = $pdo->prepare("SELECT asset_code, status, person_in_charge FROM assets WHERE asset_code IN ($placeholders)");
    $stmt->execute($codes);
    
    echo "Verification Results:\n";
    echo str_repeat("=", 50) . "\n";
    
    $count = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Asset: {$row['asset_code']}\n";
        echo "  Status: {$row['status']}\n";
        echo "  Person: {$row['person_in_charge']}\n";
        $count++;
    }
    
    echo str_repeat("=", 50) . "\n";
    echo "Total imported: $count of 4\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
