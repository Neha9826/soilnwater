<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Only add if column doesn't exist
            if (!Schema::hasColumn('order_items', 'order_id')) {
                $table->foreignId('order_id')->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('order_items', 'product_id')) {
                $table->foreignId('product_id')->after('order_id')->constrained();
            }
            if (!Schema::hasColumn('order_items', 'quantity')) {
                $table->integer('quantity')->after('product_id');
            }
            if (!Schema::hasColumn('order_items', 'price')) {
                $table->decimal('price', 10, 2)->after('quantity');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
};
