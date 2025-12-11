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
            $table->string('store_name')->nullable();
            $table->string('store_slug')->nullable()->unique(); // The URL part
            $table->text('store_description')->nullable();
            $table->string('store_logo')->nullable();
            $table->string('qr_code_path')->nullable(); // Where we save the QR image
            $table->boolean('is_vendor')->default(false);
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
