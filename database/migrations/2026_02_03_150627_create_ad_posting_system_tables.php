<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ad Tiers (Defines Grid Size & Price)
        Schema::create('ad_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Standard Square, Horizontal Rectangle
            $table->integer('grid_width')->default(1);
            $table->integer('grid_height')->default(1);
            $table->decimal('price', 8, 2)->default(0.00);
            $table->boolean('is_free')->default(false);
            $table->timestamps();
        });

        // 2. Ad Templates (The Master Templates)
        Schema::create('ad_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_tier_id')->constrained('ad_tiers')->onDelete('cascade');
            $table->string('name'); // e.g., Restaurant Grand Opening
            $table->string('blade_path'); // e.g., ads.templates.restaurant-opening
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Template Fields (Dynamic Form Definitions)
        Schema::create('ad_template_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_template_id')->constrained('ad_templates')->onDelete('cascade');
            $table->string('field_name'); // used as the HTML 'name' attribute
            $table->string('label');      // Display label for the user
            $table->string('type');       // text, number, textarea, image
            $table->boolean('is_required')->default(false);
            $table->string('placeholder')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 4. Ads (The User Instance)
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_template_id')->constrained('ad_templates');
            $table->string('title'); // Internal reference title for user
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->text('admin_remarks')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // 5. Ad Values (The actual content/EAV)
        Schema::create('ad_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained('ads')->onDelete('cascade');
            $table->foreignId('field_id')->constrained('ad_template_fields')->onDelete('cascade');
            $table->longText('value')->nullable(); // Stores text or image paths
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_values');
        Schema::dropIfExists('ads');
        Schema::dropIfExists('ad_template_fields');
        Schema::dropIfExists('ad_templates');
        Schema::dropIfExists('ad_tiers');
    }
};