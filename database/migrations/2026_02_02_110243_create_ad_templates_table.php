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
        // Migration for ad_templates (Master Designs)
        Schema::create('ad_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Beauty Clinic Style"
            $table->string('layout_file'); // e.g., "beauty-square"
            $table->json('default_data'); // Stores the base text and images
            $table->timestamps();
        });

        // Migration for user_ads (Customized copies)
        Schema::create('user_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_template_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('title'); // User's name for this specific copy
            $table->json('custom_data'); // Stores the user's edits
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_templates');
    }
};
