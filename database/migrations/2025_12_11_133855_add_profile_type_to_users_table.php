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
            // e.g. 'vendor', 'consultant', 'service', 'builder'
            $table->string('profile_type')->default('user'); 

            // For Consultants/Services (e.g. "Architect", "Plumber")
            $table->string('service_category')->nullable(); 

            // Hourly rate or Visit charge (Optional)
            $table->decimal('service_charge', 10, 2)->nullable(); 
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
