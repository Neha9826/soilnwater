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
            // 1. Link to User (Since we removed Business)
            if (!Schema::hasColumn('products', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            }

            // 2. Categorization (Replacing the old string 'category')
            $table->dropColumn('category'); 
            $table->foreignId('category_id')->nullable()->after('brand')->constrained('categories')->nullOnDelete();
            $table->foreignId('subcategory_id')->nullable()->after('category_id')->constrained('categories')->nullOnDelete();

            // 3. Inventory & Identity
            $table->string('sku')->nullable()->unique()->after('slug'); // Stock Keeping Unit
            $table->integer('low_stock_threshold')->default(5)->after('stock_quantity'); // Alert when low

            // 4. Variations (JSON is perfect for simple arrays)
            $table->json('colors')->nullable(); // e.g. ["Red", "Blue"]
            $table->json('sizes')->nullable();  // e.g. ["S", "M", "XL"]
            
            // 5. Tech Specs & SEO
            $table->json('specifications')->nullable(); // e.g. {"Material": "Cotton", "Warranty": "1 Year"}
            $table->text('meta_tags')->nullable(); // For search
            $table->string('video_url')->nullable(); // Demo video
            
            // 6. Shipping
            $table->decimal('weight', 8, 2)->nullable(); // kg
            $table->string('dimensions')->nullable(); // L x W x H
        });
    }

    public function down()
    {
        // Safety drop (simplified)
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'category_id', 'subcategory_id', 'sku', 'colors', 'sizes', 'specifications']);
            $table->string('category')->nullable();
        });
    }

    
};
