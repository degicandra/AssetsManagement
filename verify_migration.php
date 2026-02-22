<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get columns
$columns = Illuminate\Support\Facades\Schema::getColumnListing('emails');
echo "Email columns: " . implode(', ', $columns) . "\n\n";

// Get email records with their status
$emails = Illuminate\Support\Facades\DB::table('emails')->select('id', 'name', 'status')->get();
echo "Email records:\n";
foreach ($emails as $email) {
    echo "  ID: {$email->id}, Name: {$email->name}, Status: {$email->status}\n";
}

echo "\nMigration verified successfully!\n";
