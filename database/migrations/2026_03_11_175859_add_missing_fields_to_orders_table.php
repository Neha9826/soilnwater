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
        Schema::table('orders', function (Blueprint $table) {
            // Add user_id if it's missing
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade')->after('id');
            }
            
            // Add other missing fields required by your logic
            $table->string('order_number')->unique()->after('user_id');
            $table->decimal('total_amount', 10, 2)->after('order_number');
            $table->string('status')->default('pending')->after('total_amount');
            $table->string('name')->after('status');
            $table->string('phone')->after('name');
            $table->text('address')->after('phone');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
            $table->string('pincode')->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
