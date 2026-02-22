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
        Schema::table('licenses', function (Blueprint $table) {
            // Add department_id if it doesn't exist
            if (!Schema::hasColumn('licenses', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('license_key');
                $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            }
            
            // Add quantity if it doesn't exist
            if (!Schema::hasColumn('licenses', 'quantity')) {
                $table->integer('quantity')->default(1)->nullable()->after('seats');
            }
            
            // Add expiry_date if it doesn't exist
            if (!Schema::hasColumn('licenses', 'expiry_date')) {
                $table->date('expiry_date')->nullable()->after('expiration_date');
            }
        });

        // Make expiration_date nullable with default if it still exists
        if (Schema::hasColumn('licenses', 'expiration_date')) {
            DB::statement("ALTER TABLE licenses MODIFY COLUMN expiration_date DATE NULL DEFAULT NULL");
        }

        // Update status enum to include 'expired' status
        if (Schema::hasColumn('licenses', 'status')) {
            DB::statement("ALTER TABLE licenses MODIFY COLUMN status ENUM('active', 'inactive', 'expired_soon', 'expired') DEFAULT 'active'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            if (Schema::hasColumn('licenses', 'quantity')) {
                $table->dropColumn('quantity');
            }
            if (Schema::hasColumn('licenses', 'expiry_date')) {
                $table->dropColumn('expiry_date');
            }
            if (Schema::hasColumn('licenses', 'department_id')) {
                $table->dropForeign(['department_id']);
                $table->dropColumn('department_id');
            }
        });

        // Revert status enum
        if (Schema::hasColumn('licenses', 'status')) {
            DB::statement("ALTER TABLE licenses MODIFY COLUMN status ENUM('active', 'inactive', 'expired_soon') DEFAULT 'active'");
        }
    }
};
