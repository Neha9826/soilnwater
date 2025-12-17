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
        Schema::table('users', function (Blueprint $table) {
            
            // Only add 'profile_type' if it doesn't exist
            if (!Schema::hasColumn('users', 'profile_type')) {
                $table->string('profile_type')->default('customer');
            }
            
            if (!Schema::hasColumn('users', 'is_vendor')) {
                $table->boolean('is_vendor')->default(false);
            }
            
            if (!Schema::hasColumn('users', 'store_name')) {
                $table->string('store_name')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'store_slug')) {
                $table->string('store_slug')->nullable()->unique();
            }
            
            if (!Schema::hasColumn('users', 'store_logo')) {
                $table->string('store_logo')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'qr_code_path')) {
                $table->string('qr_code_path')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'service_category')) {
                $table->string('service_category')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'service_charge')) {
                $table->decimal('service_charge', 10, 2)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
