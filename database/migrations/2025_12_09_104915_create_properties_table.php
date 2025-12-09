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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->string('title'); // e.g., "3BHK Villa in Dehradun"
            $table->string('slug')->unique(); // for URL: soilnwater.in/property/3bhk-villa
            $table->text('description')->nullable();
            
            // Money
            $table->decimal('price', 15, 2); // 15 digits total, 2 decimals
            $table->enum('type', ['sale', 'rent', 'pg']); // Is it for Sale or Rent?
            
            // Property Details
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('area_sqft')->nullable();
            $table->string('furnishing')->default('unfurnished'); // furnished, semi, un
            
            // Location
            $table->string('address');
            $table->string('city')->default('Dehradun');
            $table->string('state')->default('Uttarakhand');
            $table->string('zip_code')->nullable();
            
            // Status
            $table->boolean('is_featured')->default(false); // To show on Home Page slider
            $table->boolean('is_active')->default(true); // If false, hide from public
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
