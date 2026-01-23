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
    // FIX: Drop table if it exists to avoid collision
    Schema::dropIfExists('projects');

    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        
        // Project Specifics
        $table->decimal('price', 15, 2)->nullable();
        $table->string('type')->nullable(); // Land, Apartment, etc.
        $table->string('project_status')->default('Upcoming'); // Upcoming, Ongoing, Completed
        
        // Location
        $table->string('address')->nullable();
        $table->string('city');
        $table->string('state');
        $table->text('google_map_link')->nullable();
        $table->text('google_embed_link')->nullable();

        // Media
        $table->longText('images')->nullable();
        $table->longText('videos')->nullable();
        $table->longText('documents')->nullable();

        // Promotion Logic
        $table->boolean('is_active')->default(true);
        $table->boolean('is_promoted')->default(false);
        $table->timestamp('promotion_expires_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
