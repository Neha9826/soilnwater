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
        Schema::table('users', function (Blueprint $table) {
            
            // Branding
            if (!Schema::hasColumn('users', 'store_name')) {
                $table->string('store_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'store_slug')) {
                $table->string('store_slug')->nullable()->unique();
            }
            if (!Schema::hasColumn('users', 'store_logo')) {
                $table->string('store_logo')->nullable();
            }
            
            // Header / Hero
            if (!Schema::hasColumn('users', 'header_title')) {
                $table->string('header_title')->nullable();
            }
            if (!Schema::hasColumn('users', 'header_subtitle')) {
                $table->string('header_subtitle')->nullable();
            }
            if (!Schema::hasColumn('users', 'header_images')) {
                $table->json('header_images')->nullable();
            }
            
            // Content
            if (!Schema::hasColumn('users', 'page_sections')) {
                $table->json('page_sections')->nullable();
            }
            
            // Social / Contact
            if (!Schema::hasColumn('users', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('users', 'instagram')) {
                $table->string('instagram')->nullable();
            }
            // Check 'address' specifically because Users table sometimes already has it
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable();
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
