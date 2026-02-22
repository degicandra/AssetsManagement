<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Location;
use App\Models\Asset;
use Illuminate\Support\Str;

class RandomAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing departments and locations
        $departments = Department::all();
        $locations = Location::all();
        
        if ($departments->isEmpty() || $locations->isEmpty()) {
            $this->command->error('Please run TestAssetsSeeder first to create departments and locations');
            return;
        }

        // Asset brands and models
        $brands = ['Dell', 'HP', 'Lenovo', 'Apple', 'Acer', 'Asus', 'Microsoft', 'Samsung'];
        $models = [
            'Dell' => ['Optiplex 7090', 'Inspiron 15', 'XPS 13', 'Latitude 5420'],
            'HP' => ['EliteDesk 800', 'Pavilion 15', 'ProBook 450', 'ZBook Studio'],
            'Lenovo' => ['ThinkPad X1', 'ThinkCentre M75q', 'IdeaPad 3', 'Yoga 7'],
            'Apple' => ['MacBook Pro 16', 'MacBook Air M2', 'iMac 24', 'Mac Studio'],
            'Acer' => ['Aspire 5', 'Predator Helios', 'Swift 3', 'Chromebook 314'],
            'Asus' => ['VivoBook 15', 'ROG Strix', 'ZenBook 14', 'ExpertBook B9'],
            'Microsoft' => ['Surface Laptop 5', 'Surface Pro 9', 'Surface Studio 2'],
            'Samsung' => ['Galaxy Book2', 'NP950XED', 'Chromebook 4']
        ];

        // Person in charge names
        $personNames = [
            'John Smith', 'Jane Doe', 'Mike Johnson', 'Sarah Wilson', 'David Brown',
            'Lisa Davis', 'Robert Miller', 'Jennifer Taylor', 'Michael Anderson', 'Mary Thomas',
            'Christopher Jackson', 'Amanda White', 'Daniel Harris', 'Jessica Martin', 'Matthew Thompson',
            'Ashley Garcia', 'Andrew Martinez', 'Brittany Robinson', 'Joshua Clark', 'Samantha Rodriguez'
        ];

        // Companies
        $companies = ['Company A', 'Company B', 'Company C', 'Tech Solutions Inc', 'Global Enterprises'];

        // Asset statuses
        $statuses = [
            'ready_to_deploy',
            'deployed',
            'archive',
            'broken',
            'service',
            'request_disposal',
            'disposed'
        ];

        // Storage types and sizes
        $storageTypes = ['SSD', 'HDD'];
        $storageSizes = ['128GB', '256GB', '512GB', '1TB', '2TB'];
        $ramSizes = ['4GB', '8GB', '16GB', '32GB', '64GB'];

        // Processors
        $processors = [
            'Intel i3-10100', 'Intel i5-10500', 'Intel i7-10700', 'Intel i9-10900',
            'AMD Ryzen 3 5300G', 'AMD Ryzen 5 5600G', 'AMD Ryzen 7 5700G', 'AMD Ryzen 9 5900X',
            'Apple M1', 'Apple M1 Pro', 'Apple M1 Max', 'Apple M2'
        ];

        // Generate 50 random assets
        for ($i = 1; $i <= 50; $i++) {
            $brand = $brands[array_rand($brands)];
            $model = $models[$brand][array_rand($models[$brand])];
            $company = $companies[array_rand($companies)];
            $person = $personNames[array_rand($personNames)];
            $status = $statuses[array_rand($statuses)];
            $department = $departments->random();
            $location = $locations->random();
            
            // Generate unique asset code
            $assetCode = strtoupper(substr($brand, 0, 2)) . str_pad($i, 3, '0', STR_PAD_LEFT);
            
            // Generate unique serial number
            $serialNumber = 'SN' . str_pad($i, 6, '0', STR_PAD_LEFT);
            
            // Random purchase date (within last 3 years)
            $purchaseDate = now()->subDays(rand(0, 1095))->format('Y-m-d');
            
            // Random warranty expiration (1-5 years from purchase)
            $warrantyExpiration = date('Y-m-d', strtotime($purchaseDate . ' + ' . rand(365, 1825) . ' days'));
            
            // Random specs (not all assets have specs)
            $hasSpecs = rand(0, 100) > 30; // 70% chance to have specs
            $processor = $hasSpecs ? $processors[array_rand($processors)] : null;
            $storageType = $hasSpecs ? $storageTypes[array_rand($storageTypes)] : null;
            $storageSize = $hasSpecs ? $storageSizes[array_rand($storageSizes)] : null;
            $ram = $hasSpecs ? $ramSizes[array_rand($ramSizes)] : null;
            
            // Random notes (30% chance)
            $notes = rand(0, 100) > 70 ? 'Random asset generated for testing purposes' : null;
            
            // Create the asset
            Asset::create([
                'company' => $company,
                'asset_code' => $assetCode,
                'serial_number' => $serialNumber,
                'model' => $model,
                'brand' => $brand,
                'status' => $status,
                'location_id' => $location->id,
                'department_id' => $department->id,
                'person_in_charge' => $person,
                'purchase_date' => $purchaseDate,
                'warranty_expiration' => $warrantyExpiration,
                'processor' => $processor,
                'storage_type' => $storageType,
                'storage_size' => $storageSize,
                'ram' => $ram,
                'notes' => $notes,
                'is_active' => 1
            ]);
        }
        
        $this->command->info('50 random assets created successfully!');
    }
}