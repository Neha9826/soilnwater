<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Update Products Table (Check if columns exist first)
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'is_approved')) {
                $table->boolean('is_approved')->default(false);
            }
            if (!Schema::hasColumn('products', 'admin_rejection_reason')) {
                $table->text('admin_rejection_reason')->nullable();
            }
        });

        // 2. Update Businesses Table (Check if columns exist first)
        Schema::table('businesses', function (Blueprint $table) {
            
            // Add is_active if missing
            if (!Schema::hasColumn('businesses', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            
            // Add approval columns if missing
            if (!Schema::hasColumn('businesses', 'is_approved')) {
                $table->boolean('is_approved')->default(false);
            }
            if (!Schema::hasColumn('businesses', 'admin_rejection_reason')) {
                $table->text('admin_rejection_reason')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'is_approved')) {
                $table->dropColumn(['is_approved', 'admin_rejection_reason']);
            }
        });
        
        Schema::table('businesses', function (Blueprint $table) {
            if (Schema::hasColumn('businesses', 'is_approved')) {
                $table->dropColumn(['is_approved', 'admin_rejection_reason']);
            }
            if (Schema::hasColumn('businesses', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};