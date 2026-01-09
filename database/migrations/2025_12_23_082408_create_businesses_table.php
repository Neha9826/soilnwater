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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // The Owner
            
            // Basic Info
            $table->string('name');
            $table->string('slug')->unique(); // For the public URL (soilnwater.in/v/slug)
            $table->string('type'); // e.g., 'retail', 'service', 'real-estate'
            $table->text('about_text')->nullable();
            
            // Branding (Moved from Users)
            $table->string('logo')->nullable();
            $table->string('header_title')->nullable();
            $table->string('header_subtitle')->nullable();
            $table->json('header_images')->nullable();
            $table->json('page_sections')->nullable(); // The Website Builder Data
            
            // Contact
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();

            // KYC & Docs (The Twist)
            $table->string('pan_number')->nullable();
            $table->string('adhaar_number')->nullable();
            $table->string('gst_number')->nullable(); // Optional based on type
            $table->string('license_number')->nullable(); // Optional
            $table->boolean('is_verified')->default(false);

            $table->string('qr_code_path')->nullable();

            $table->timestamps();
        });

        // CRITICAL: Update Products to belong to a BUSINESS, not a User
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('business_id')->nullable()->after('id');
            // We will drop user_id later, for now let's keep it until migration is done
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
