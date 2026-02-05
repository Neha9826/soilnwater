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
    // Add this wrapper to prevent the "Table already exists" error
    if (!Schema::hasTable('ad_values')) {
        Schema::create('ad_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->foreignId('field_id')->constrained('ad_template_fields')->onDelete('cascade');
            $table->text('value')->nullable(); 
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_values');
    }
};
