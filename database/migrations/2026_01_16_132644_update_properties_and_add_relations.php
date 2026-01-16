<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Update Properties Table
        Schema::table('properties', function (Blueprint $table) {
            $table->json('videos')->nullable()->after('images');
            $table->json('documents')->nullable()->after('videos');
            // Ensure type column can hold the new string if it was an enum, 
            // otherwise standard string columns accept "Share a Space" automatically.
        });

        // 2. Create Amenities Table
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // 3. Create Pivot Table (Property <-> Amenity)
        Schema::create('amenity_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('amenity_id')->constrained()->cascadeOnDelete();
        });

        // 4. Create Floor Plans Table
        Schema::create('property_floors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('floor_name'); // e.g. "Ground Floor", "1st Floor"
            $table->string('area_sqft')->nullable();
            $table->integer('rooms')->nullable();
            $table->string('image_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        // Seed some default amenities
        DB::table('amenities')->insert([
            ['name' => 'WiFi'], ['name' => 'Parking'], ['name' => 'Swimming Pool'], 
            ['name' => 'Gym'], ['name' => '24/7 Security']
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('property_floors');
        Schema::dropIfExists('amenity_property');
        Schema::dropIfExists('amenities');
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['videos', 'documents']);
        });
    }
};