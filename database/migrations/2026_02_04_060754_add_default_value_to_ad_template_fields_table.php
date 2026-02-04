<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ad_template_fields', function (Blueprint $table) {
            // Adding the column for Admin's Master Content
            $table->text('default_value')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('ad_template_fields', function (Blueprint $table) {
            $table->dropColumn('default_value');
        });
    }
};