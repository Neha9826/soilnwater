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
        Schema::table('products', function (Blueprint $table) {
            
            // Link Product to a Vendor (User)
            if (!Schema::hasColumn('products', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            }

            // Add Missing Toggles
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
            
            if (!Schema::hasColumn('products', 'in_stock')) {
                $table->boolean('in_stock')->default(true);
            }

            if (!Schema::hasColumn('products', 'on_sale')) {
                $table->boolean('on_sale')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
