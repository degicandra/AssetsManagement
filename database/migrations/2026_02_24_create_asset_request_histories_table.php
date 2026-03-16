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
        Schema::create('asset_request_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_request_id')->constrained()->onDelete('cascade');
            $table->string('previous_status')->nullable();
            $table->string('new_status');
            $table->text('notes')->nullable();
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_request_histories');
    }
};
