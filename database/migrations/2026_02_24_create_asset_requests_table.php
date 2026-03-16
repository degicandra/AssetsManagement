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
        Schema::create('asset_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('item_description');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('floor_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null');
            $table->string('requested_by');
            $table->date('request_date');
            $table->enum('status', [
                'request_created',
                'finance_approval',
                'director_approval',
                'submitted_purchasing',
                'item_purchased'
            ])->default('request_created');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_requests');
    }
};
