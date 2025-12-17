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
            // Landing Page Details
            if (!Schema::hasColumn('users', 'header_images')) {
                $table->json('header_images')->nullable(); // Multiple images
            }
            if (!Schema::hasColumn('users', 'about_text')) {
                $table->text('about_text')->nullable();
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable();
            }

            // Social Links
            if (!Schema::hasColumn('users', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('users', 'instagram')) {
                $table->string('instagram')->nullable();
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
