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
        Schema::table('properties', function (Blueprint $table) {
            // 1. Who is posting?
            $table->string('poster_type')->nullable(); // 'Owner' or 'Broker'
            
            // 2. Is it government registered?
            $table->boolean('is_govt_registered')->default(false);
            
            // 3. Broad Category (Land vs Pre-built) - Helps filter the next dropdown
            $table->string('category_type')->nullable(); // 'Land' or 'Pre-built'
            
            // 4. For "Others" selection
            $table->string('other_type_details')->nullable(); 

            // 5. For the "Project/Promotion" part (Point 2 of your request)
            $table->boolean('sell_via_us')->default(false);
            $table->decimal('commission_percentage', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['poster_type', 'is_govt_registered', 'category_type', 'other_type_details', 'sell_via_us', 'commission_percentage']);
        });
    }
};
