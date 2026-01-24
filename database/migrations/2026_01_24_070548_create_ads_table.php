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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('title');
            $table->string('type'); // 'upload' or 'builder'
            $table->string('size_format')->default('square'); // square, story, banner
            
            // The Final Image (displayed on frontend)
            $table->string('final_image_path'); 
            
            // For Builder Mode: Saves the editable state
            $table->json('design_data')->nullable(); 
            
            $table->string('target_link')->nullable(); // Where the ad clicks to
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
