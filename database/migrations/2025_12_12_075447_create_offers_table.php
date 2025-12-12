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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Monsoon Paint Sale"
            $table->string('discount_tag'); // e.g., "FLAT 20% OFF" or "BUY 1 GET 1"
            $table->string('coupon_code')->nullable(); // e.g., "PAINT20"
            
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
