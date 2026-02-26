<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    protected $fillable = [
        'name', 
        'slug', 
        'commission_percentage', 
        'is_approved', 
        'created_by'
    ];

    /**
     * Relationship: One Category has many Sub-Categories
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(ProductSubCategory::class, 'product_category_id');
    }

    /**
     * Relationship: One Category has many Products
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
}