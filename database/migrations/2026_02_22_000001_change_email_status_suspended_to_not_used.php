<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum column first to include 'not used'
        Schema::table('emails', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'suspended', 'not used'])->default('active')->change();
        });
        
        // Update existing 'suspended' to 'not used'
        DB::table('emails')->where('status', 'suspended')->update(['status' => 'not used']);
        
        // Now remove 'suspended' from the enum
        Schema::table('emails', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'not used'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update existing 'not used' back to 'suspended'
        DB::table('emails')->where('status', 'not used')->update(['status' => 'suspended']);
        
        // Modify the enum column back
        Schema::table('emails', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'suspended'])->change();
        });
    }
};
