<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Support\Str;

class ProductSubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Electronics & Accessories' => ['Laptops', 'Headphones', 'Smart Watches', 'Cameras'],
            'Mobile Phones' => ['Android Phones', 'iPhones', 'Refurbished Mobiles', 'Feature Phones'],
            'Fashion & Apparel' => ['Mens Wear', 'Womens Wear', 'Kids Clothing', 'Footwear'],
            'Home & Furniture' => ['Kitchen Appliances', 'Sofas & Beds', 'Home Decor', 'Lighting'],
            'Industrial Tools & Construction' => ['Power Drills', 'Cement & Concrete', 'Safety Gear', 'Hand Tools'],
            'Grocery & FMCG' => ['Snacks', 'Beverages', 'Personal Hygiene', 'Household Cleaning'],
        ];

        foreach ($data as $parentName => $subs) {
            // Find the parent category created by the previous seeder
            $parent = ProductCategory::where('name', $parentName)->first();

            if ($parent) {
                foreach ($subs as $subName) {
                    ProductSubCategory::updateOrCreate(
                        ['slug' => Str::slug($subName), 'product_category_id' => $parent->id],
                        ['name' => $subName]
                    );
                }
            }
        }
    }
}