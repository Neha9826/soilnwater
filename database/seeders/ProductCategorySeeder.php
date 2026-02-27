<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics & Accessories',
                'commission' => 8.00, // Based on Amazon 5-8%
            ],
            [
                'name' => 'Mobile Phones',
                'commission' => 6.00, // Midpoint of Amazon/Flipkart
            ],
            [
                'name' => 'Fashion & Apparel',
                'commission' => 15.00, // Average for high-margin lifestyle
            ],
            [
                'name' => 'Beauty & Personal Care',
                'commission' => 10.00, // Competitive market rate
            ],
            [
                'name' => 'Home & Furniture',
                'commission' => 12.00, // Based on Flipkart 10-18%
            ],
            [
                'name' => 'Industrial Tools & Construction',
                'commission' => 7.50, // Standard B2B marketplace rate
            ],
            [
                'name' => 'Grocery & FMCG',
                'commission' => 5.00, // Low margin, high volume
            ],
        ];

        foreach ($categories as $cat) {
            ProductCategory::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'commission_percentage' => $cat['commission'],
                    'is_approved' => true,
                ]
            );
        }
    }
}