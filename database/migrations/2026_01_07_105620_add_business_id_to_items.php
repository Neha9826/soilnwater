<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1. Check Products Table
        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'business_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('business_id')->nullable()->constrained()->onDelete('cascade');
            });
        }

        // 2. Check Properties Table
        if (Schema::hasTable('properties') && !Schema::hasColumn('properties', 'business_id')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->foreignId('business_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
        
        // 3. Check Services Table (Optional)
        if (Schema::hasTable('services') && !Schema::hasColumn('services', 'business_id')) {
            Schema::table('services', function (Blueprint $table) {
                $table->foreignId('business_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
};
