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
    // 1. If table doesn't exist, create it normally
    if (!Schema::hasTable('categories')) {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_approved')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    } 
    // 2. If table ALREADY exists, handle the data carefully
    else {
        Schema::table('categories', function (Blueprint $table) {
            // A. Add columns WITHOUT unique constraint first
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
            if (!Schema::hasColumn('categories', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('id');
                $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            }
            if (!Schema::hasColumn('categories', 'image')) {
                $table->string('image')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('categories', 'is_approved')) {
                $table->boolean('is_approved')->default(true)->after('is_active');
            }
            if (!Schema::hasColumn('categories', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users');
            }
        });

        // B. FILL THE SLUGS (Fixes the "Duplicate Entry" error)
        $categories = \DB::table('categories')->whereNull('slug')->orWhere('slug', '')->get();
        foreach ($categories as $cat) {
            // Create a slug from the name. Append ID to ensure it is 100% unique.
            $slug = \Illuminate\Support\Str::slug($cat->name) . '-' . $cat->id; 
            \DB::table('categories')->where('id', $cat->id)->update(['slug' => $slug]);
        }

        // C. NOW apply the Unique Constraint
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change(); // Make it required
            // unique() might fail if index exists, so we wrap it
            try {
                $table->unique('slug'); 
            } catch (\Exception $e) {}
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
