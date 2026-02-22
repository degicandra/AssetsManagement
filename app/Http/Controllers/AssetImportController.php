<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\Department;
use App\Models\Location;
use Illuminate\Http\Request;

class AssetImportController extends Controller
{
    public function showImportForm()
    {
        $departments = Department::all();
        $locations = Location::all();
        $types = AssetType::all();
        
        return view('assets.import', compact('departments', 'locations', 'types'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        
        // Read file and detect delimiter
        $fileContent = file_get_contents($path);
        $lines = file($path);
        $firstLine = $lines[0] ?? '';
        
        // Detect delimiter (comma or semicolon)
        $delimiter = (strpos($firstLine, ';') !== false) ? ';' : ',';
        
        // Parse CSV with detected delimiter
        $data = [];
        foreach ($lines as $line) {
            $data[] = str_getcsv(trim($line), $delimiter);
        }
        
        // Remove header row
        array_shift($data);

        $imported = 0;
        $errors = [];
        $rowNumber = 2; // Start from row 2 (after header)

        foreach ($data as $row) {
            try {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    $rowNumber++;
                    continue;
                }

                // Map CSV columns to asset fields
                $assetData = [
                    'company' => $row[0] ?? null,
                    'asset_code' => $row[1] ?? null,
                    'serial_number' => (trim($row[2] ?? '') === '-' || empty($row[2])) ? null : $row[2],
                    'model' => $row[3] ?? null,
                    'brand' => $row[4] ?? null,
                    'type_id' => $this->getTypeId($row[5] ?? null),
                    'status' => $row[6] ?? 'active',
                    'location_id' => $this->getLocationId($row[7] ?? null),
                    'department_id' => $this->getDepartmentId($row[8] ?? null),
                    'person_in_charge' => $row[9] ?? null,
                    'purchase_date' => $this->parseDate($row[10] ?? null),
                    'warranty_expiration' => $this->parseDate($row[11] ?? null),
                    'processor' => $row[12] ?? null,
                    'storage_type' => $row[13] ?? null,
                    'storage_size' => $row[14] ?? null,
                    'ram' => $row[15] ?? null,
                    'specification_upgraded' => $row[16] ?? 0,
                    'notes' => $row[17] ?? null,
                    'is_active' => (strtolower($row[18] ?? 'yes') === 'yes' || $row[18] == '1') ? 1 : 0,
                ];

                // Validate required fields
                if (empty($assetData['asset_code'])) {
                    throw new \Exception('Asset code is required');
                }

                Asset::create($assetData);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Row {$rowNumber}: " . $e->getMessage();
            }

            $rowNumber++;
        }

        return redirect()->route('assets.index')->with([
            'import_success' => "Successfully imported {$imported} assets.",
            'import_errors' => $errors,
        ]);
    }

    public function downloadTemplate()
    {
        $filename = 'asset_import_template.csv';
        $headers = [
            'Company',
            'Asset Code',
            'Serial Number',
            'Model',
            'Brand',
            'Type',
            'Status',
            'Location',
            'Department',
            'Person In Charge',
            'Purchase Date (YYYY-MM-DD)',
            'Warranty Expiration (YYYY-MM-DD)',
            'Processor',
            'Storage Type',
            'Storage Size',
            'RAM',
            'Specification Upgraded (0/1)',
            'Notes',
            'Is Active (yes/no)'
        ];

        $handle = fopen('php://memory', 'w');
        fputcsv($handle, $headers);
        
        // Add example row
        $example = [
            'PT Tech Indonesia',
            'ASSET001',
            'SN123456789',
            'ThinkPad X1 Carbon',
            'Lenovo',
            'Laptop',
            'active',
            'Floor 1 - Office A',
            'IT Department',
            'John Doe',
            '2024-01-15',
            '2026-01-15',
            'Intel Core i7',
            'SSD',
            '512GB',
            '16GB',
            '1',
            'Recently upgraded to SSD',
            'yes'
        ];
        fputcsv($handle, $example);

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    private function getTypeId($typeName)
    {
        if (empty($typeName)) return null;
        
        $type = AssetType::where('name', 'like', "%{$typeName}%")->first();
        return $type ? $type->id : null;
    }

    private function getDepartmentId($departmentName)
    {
        if (empty($departmentName)) return null;
        
        $department = Department::where('name', 'like', "%{$departmentName}%")->first();
        return $department ? $department->id : null;
    }

    private function getLocationId($locationName)
    {
        if (empty($locationName)) return null;
        
        $location = Location::where('name', 'like', "%{$locationName}%")->first();
        return $location ? $location->id : null;
    }

    private function parseDate($dateString)
    {
        if (empty($dateString)) return null;

        try {
            // Try to parse various date formats
            return \Carbon\Carbon::createFromFormat('Y-m-d', $dateString)->toDateTimeString();
        } catch (\Exception $e) {
            try {
                return \Carbon\Carbon::createFromFormat('d/m/Y', $dateString)->toDateTimeString();
            } catch (\Exception $e) {
                return null;
            }
        }
    }
}
