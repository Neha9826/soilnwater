<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // 1. Get the Specific User (vendor1@test.com)
        $user = User::where('email', 'vendor1@test.com')->first();

        // If user doesn't exist, create them instantly so the seeder doesn't fail
        if (!$user) {
            $user = User::create([
                'name' => 'Vendor One',
                'email' => 'vendor1@test.com',
                'password' => Hash::make('password'), // Default password
                'profile_type' => 'vendor',
                'store_name' => 'Vendor Hardware',
                'store_slug' => 'vendor-hardware',
            ]);
        }

        // 2. Find or Create the 'Hardware Store' Category
        // We add 'type' => 'product' to fix the SQL error
        $category = Category::where('slug', 'hardware-store')->first();
        
        if (!$category) {
            $category = Category::create([
                'name' => 'Hardware Store',
                'slug' => 'hardware-store',
                'is_active' => true,
                'is_approved' => true,
                'created_by' => $user->id,
                'type' => 'product' // <--- FIXED: Added missing field
            ]);
        }

        // 3. Create Subcategories (with 'type' field included)
        $subCatTools = Category::firstOrCreate(
            ['slug' => 'power-tools'],
            [
                'name' => 'Power Tools',
                'parent_id' => $category->id,
                'is_active' => true,
                'is_approved' => true,
                'type' => 'product' // <--- FIXED
            ]
        );

        $subCatBuild = Category::firstOrCreate(
            ['slug' => 'building-materials'],
            [
                'name' => 'Building Materials',
                'parent_id' => $category->id,
                'is_active' => true,
                'is_approved' => true,
                'type' => 'product' // <--- FIXED
            ]
        );

        // 4. Define the Products
        $products = [
            [
                'name' => 'Bosch GSB 500W Professional Impact Drill',
                'brand' => 'Bosch',
                'price' => 4500.00,
                'stock_quantity' => 25,
                'subcategory_id' => $subCatTools->id,
                'description' => 'Robust and powerful 500W motor. Extremely compact for working in tight spaces and overhead. Low weight of only 1.5 kg for fatigue-free working.',
                'colors' => ['Blue', 'Black'],
                'specifications' => ['Power' => '500W', 'Chuck Capacity' => '13mm', 'Warranty' => '1 Year', 'RPM' => '2600'],
                'weight' => 1.5,
                'dimensions' => '25x20x10 cm'
            ],
            [
                'name' => 'UltraTech Portland Pozzolana Cement (50kg)',
                'brand' => 'UltraTech',
                'price' => 380.00,
                'stock_quantity' => 500,
                'subcategory_id' => $subCatBuild->id,
                'description' => 'Premium quality cement for high durability concrete. Ideal for home construction and plastering work.',
                'colors' => ['Grey'],
                'specifications' => ['Grade' => 'PPC', 'Packaging' => 'Paper Bag', 'Setting Time' => '30 Mins'],
                'weight' => 50.00,
                'dimensions' => '60x40x20 cm'
            ],
            [
                'name' => 'Asian Paints Royale Luxury Emulsion (20L)',
                'brand' => 'Asian Paints',
                'price' => 8200.00,
                'stock_quantity' => 10,
                'subcategory_id' => $subCatBuild->id,
                'description' => 'Luxury interior paint that provides a smooth finish. Teflon surface protector makes it easily washable.',
                'colors' => ['White', 'Off-White', 'Cream'],
                'specifications' => ['Finish' => 'Soft Sheen', 'Washability' => 'High', 'Coverage' => '240 sq.ft/L'],
                'weight' => 22.00,
                'dimensions' => '30x30x40 cm'
            ],
            [
                'name' => 'Taparia 101 Steel Screw Driver Set',
                'brand' => 'Taparia',
                'price' => 450.00,
                'stock_quantity' => 100,
                'subcategory_id' => $subCatTools->id,
                'description' => 'High grade steel blades with magnetic tips. Includes neon bulb for electrical testing.',
                'colors' => ['Green/Yellow'],
                'specifications' => ['Pieces' => '5', 'Material' => 'Alloy Steel', 'Type' => 'Magnetic'],
                'weight' => 0.4,
                'dimensions' => '15x10x5 cm'
            ],
            [
                'name' => 'Havells 2.5 sq mm Copper Wire (90m)',
                'brand' => 'Havells',
                'price' => 2100.00,
                'stock_quantity' => 45,
                'subcategory_id' => $subCatBuild->id,
                'description' => 'Heat resistant flame retardant (HRFR) PVC insulated industrial cables.',
                'colors' => ['Red', 'Black', 'Blue', 'Yellow'],
                'specifications' => ['Length' => '90m', 'Conductor' => 'Copper', 'Insulation' => 'PVC'],
                'weight' => 3.2,
                'dimensions' => '20x20x10 cm'
            ],
            [
                'name' => 'Stanley Claw Hammer (Fiberglass Handle)',
                'brand' => 'Stanley',
                'price' => 650.00,
                'stock_quantity' => 30,
                'subcategory_id' => $subCatTools->id,
                'description' => 'Fiberglass handle absorbs shock and vibration. Textured rubber grip for comfort.',
                'colors' => ['Yellow/Black'],
                'specifications' => ['Head Weight' => '450g', 'Handle' => 'Fiberglass', 'Face' => 'Polished'],
                'weight' => 0.7,
                'dimensions' => '35x12x5 cm'
            ],
        ];

        // 5. Insert Loop
        foreach ($products as $p) {
            Product::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'subcategory_id' => $p['subcategory_id'],
                'name' => $p['name'],
                'slug' => Str::slug($p['name']) . '-' . Str::random(4),
                'description' => $p['description'],
                'price' => $p['price'],
                'brand' => $p['brand'],
                'stock_quantity' => $p['stock_quantity'],
                'sku' => strtoupper(substr($p['brand'], 0, 3)) . '-' . rand(1000, 9999),
                'colors' => $p['colors'],
                'specifications' => $p['specifications'],
                'weight' => $p['weight'],
                'dimensions' => $p['dimensions'],
                'images' => [], 
                'is_active' => true,
            ]);
        }

        $this->command->info('Products seeded for user: ' . $user->email);
    }
}