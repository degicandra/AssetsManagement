<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\AssetType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create a default asset type "General" if it doesn't exist
        $defaultType = AssetType::firstOrCreate(
            ['name' => 'General'],
            [
                'description' => 'General asset type for unclassified assets',
                'is_active' => true
            ]
        );

        // Update all assets that don't have a type_id to use the default type
        DB::table('assets')
            ->whereNull('type_id')
            ->update(['type_id' => $defaultType->id]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove type_id from assets that were assigned the default type
        $defaultType = AssetType::where('name', 'General')->first();
        
        if ($defaultType) {
            DB::table('assets')
                ->where('type_id', $defaultType->id)
                ->update(['type_id' => null]);
        }
    }
};
