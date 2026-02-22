<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('software_name');
            $table->string('license_key')->unique();
            $table->foreignId('asset_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['active', 'inactive', 'expired_soon']);
            $table->date('purchase_date');
            $table->date('expiration_date');
            $table->integer('seats')->default(1);
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
