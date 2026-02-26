<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSubCategory extends Model
{
    protected $fillable = ['product_category_id', 'name', 'slug'];

    public function category()
    {
        // Links the subcategory to a category already created in the DB
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}