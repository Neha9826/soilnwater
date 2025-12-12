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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Skyline Towers"
            $table->string('slug')->unique();
            
            $table->string('location'); // e.g., "Rajpur Road"
            $table->string('city')->default('Dehradun');
            
            $table->string('rera_id')->nullable(); // Important for Builders
            $table->string('status'); // 'Upcoming', 'Under Construction', 'Ready to Move'
            $table->date('completion_date')->nullable();
            
            $table->text('description')->nullable();
            $table->json('images')->nullable(); // Project Gallery
            $table->json('amenities')->nullable(); // Club house, Gym, etc.
            
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
