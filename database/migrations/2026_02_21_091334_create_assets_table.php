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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('asset_code')->unique();
            $table->string('serial_number')->nullable();
            $table->string('model');
            $table->string('brand');
            $table->enum('status', ['ready_to_deploy', 'deployed', 'archive', 'broken', 'service', 'request_disposal', 'disposed']);
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('person_in_charge');
            $table->date('purchase_date');
            $table->date('warranty_expiration')->nullable();
            
            // Optional specifications
            $table->string('processor')->nullable();
            $table->enum('storage_type', ['HDD', 'SSD'])->nullable();
            $table->string('storage_size')->nullable();
            $table->string('ram')->nullable();
            $table->string('image_path')->nullable();
            
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
        Schema::dropIfExists('assets');
    }
};
