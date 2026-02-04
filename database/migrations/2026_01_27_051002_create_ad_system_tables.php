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
        // 1. Ad Tiers (The Pricing Model)
        Schema::create('ad_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Standard Square", "Hero Banner"
            $table->string('code')->unique(); // e.g., 'square_1x1', 'hero'
            $table->decimal('price', 10, 2); // Daily or One-time price
            $table->integer('width_units')->default(1); // 1 grid unit
            $table->integer('height_units')->default(1); // 1 grid unit
            $table->boolean('is_premium')->default(false); // For Hero/Index placement
            $table->timestamps();
        });

        // 2. Ad Templates (The Pre-designed Layouts)
        Schema::create('ad_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_tier_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "Modern Sale", "Simple Text"
            $table->string('view_component'); // The Blade component name to render this
            $table->json('required_fields'); // e.g., ['headline', 'phone', 'image']
            $table->string('thumbnail')->nullable(); // Preview image for selection
            $table->timestamps();
        });

        // 3. Update the existing 'ads' table
        Schema::table('ads', function (Blueprint $table) {
            // Drop old columns if they exist from previous attempts
            // $table->dropColumn(['type', 'size_format', 'design_data']); 
            
            $table->foreignId('ad_tier_id')->nullable()->constrained();
            $table->foreignId('ad_template_id')->nullable()->constrained();
            $table->string('bg_color')->default('#ffffff');
            $table->json('content_data')->nullable(); // Stores user inputs: {headline: "Sale", phone: "123"}
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('status')->default('draft'); // draft, pending_payment, active
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_templates');
        Schema::dropIfExists('ad_tiers');
    }
};
