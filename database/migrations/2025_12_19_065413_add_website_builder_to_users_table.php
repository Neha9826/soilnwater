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
            // 1. Branding
            // store_logo was added earlier, checking just in case
            if (!Schema::hasColumn('users', 'store_logo')) {
                $table->string('store_logo')->nullable();
            }

            // 2. Custom Header Text
            $table->string('header_title')->nullable(); // e.g. "Building Dreams Since 1990"
            $table->string('header_subtitle')->nullable(); // e.g. "Dehradun's #1 Hardware Store"

            // 3. Dynamic Sections (The Website Builder)
            // Stores: [{ title, description, image_path }]
            $table->json('page_sections')->nullable();
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
