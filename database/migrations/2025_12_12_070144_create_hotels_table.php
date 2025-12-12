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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "The Doon Residency"
            $table->string('slug')->unique();
            $table->string('type'); // Hotel, Resort, Homestay
            
            $table->string('city')->default('Dehradun');
            $table->string('address');
            $table->text('description')->nullable();
            
            $table->decimal('price_per_night', 10, 2);
            $table->integer('star_rating')->default(3); // 1 to 5
            
            // JSON columns for rich data
            $table->json('amenities')->nullable(); // [WiFi, Pool, Parking]
            $table->json('images')->nullable();
            
            $table->string('contact_phone');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
