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
        Schema::create('product_categories', function (Blueprint $table) 
        {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('commission_percentage', 5, 2)->default(0.00); // Amazon-style commission
            $table->boolean('is_approved')->default(true);
            $table->unsignedBigInteger('created_by')->nullable(); // For "Other" logic
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
