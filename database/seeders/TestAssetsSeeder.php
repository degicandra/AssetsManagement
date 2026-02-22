<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Floor;
use App\Models\Location;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Date;

class TestAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create departments
        $departments = [
            ['name' => 'IT Department', 'code' => 'IT', 'description' => 'Information Technology'],
            ['name' => 'HR Department', 'code' => 'HR', 'description' => 'Human Resources'],
            ['name' => 'Finance Department', 'code' => 'FIN', 'description' => 'Finance'],
        ];
        
        foreach ($departments as $dept) {
            Department::create($dept);
        }
        
        // Create floors
        $floors = [
            ['name' => 'Ground Floor', 'floor_number' => 'GF'],
            ['name' => 'First Floor', 'floor_number' => '1F'],
            ['name' => 'Second Floor', 'floor_number' => '2F'],
        ];
        
        foreach ($floors as $floor) {
            Floor::create($floor);
        }
        
        // Create locations
        $locations = [
            ['name' => 'Server Room', 'floor_id' => 1],
            ['name' => 'IT Office', 'floor_id' => 1],
            ['name' => 'HR Office', 'floor_id' => 2],
            ['name' => 'Finance Office', 'floor_id' => 3],
        ];
        
        foreach ($locations as $loc) {
            Location::create($loc);
        }
        
        // Create some test assets
        $assets = [
            [
                'company' => 'Company A',
                'asset_code' => 'PC001',
                'serial_number' => 'SN001',
                'model' => 'Dell Optiplex 7090',
                'brand' => 'Dell',
                'status' => 'ready_to_deploy',
                'location_id' => 1,
                'department_id' => 1,
                'person_in_charge' => 'John Doe',
                'purchase_date' => '2023-01-15',
                'processor' => 'Intel i7-10700',
                'storage_type' => 'SSD',
                'storage_size' => '512GB',
                'ram' => '16GB',
            ],
            [
                'company' => 'Company A',
                'asset_code' => 'PC002',
                'serial_number' => 'SN002',
                'model' => 'HP EliteDesk 800',
                'brand' => 'HP',
                'status' => 'deployed',
                'location_id' => 2,
                'department_id' => 1,
                'person_in_charge' => 'Jane Smith',
                'purchase_date' => '2023-02-20',
                'processor' => 'Intel i5-10500',
                'storage_type' => 'HDD',
                'storage_size' => '1TB',
                'ram' => '8GB',
            ],
            [
                'company' => 'Company A',
                'asset_code' => 'LAP001',
                'serial_number' => 'SN003',
                'model' => 'MacBook Pro 16',
                'brand' => 'Apple',
                'status' => 'archive',
                'location_id' => 3,
                'department_id' => 2,
                'person_in_charge' => 'Mike Johnson',
                'purchase_date' => '2022-06-10',
                'processor' => 'M1 Pro',
                'storage_type' => 'SSD',
                'storage_size' => '512GB',
                'ram' => '16GB',
            ],
            [
                'company' => 'Company A',
                'asset_code' => 'PRN001',
                'serial_number' => 'SN004',
                'model' => 'HP LaserJet Pro',
                'brand' => 'HP',
                'status' => 'broken',
                'location_id' => 4,
                'department_id' => 3,
                'person_in_charge' => 'Sarah Wilson',
                'purchase_date' => '2021-11-05',
            ],
        ];
        
        foreach ($assets as $asset) {
            Asset::create($asset);
        }
    }
}
