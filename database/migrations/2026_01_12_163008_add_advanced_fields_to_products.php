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
        Schema::table('products', function (Blueprint $table) {
            // 1. Discount & Selling
            $table->integer('discount_percentage')->default(0)->after('price');
            $table->decimal('discounted_price', 10, 2)->nullable()->after('discount_percentage');
            $table->boolean('is_sellable')->default(false)->after('is_active'); // The "Click to Sell" switch

            // 2. Advanced B2B & Offers
            $table->json('tiered_pricing')->nullable(); // For Unit-wise pricing (1->10, 10->90)
            $table->decimal('shipping_charges', 8, 2)->default(0.00)->after('weight');
            
            // 3. Special Offers
            $table->boolean('has_special_offer')->default(false);
            $table->text('special_offer_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['discount_percentage', 'discounted_price', 'is_sellable', 'tiered_pricing', 'shipping_charges', 'has_special_offer', 'special_offer_text']);
        });
    }
};
