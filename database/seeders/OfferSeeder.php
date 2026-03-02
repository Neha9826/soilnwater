<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\User;
use App\Models\ProductCategory;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get all Vendors and Builders
        $businessUsers = User::whereIn('profile_type', ['vendor', 'builder'])->get();

        // 2. Fetch some categories to link
        $categories = ProductCategory::all();

        foreach ($businessUsers as $user) {
            // Determine offer title based on profile type
            $title = ($user->profile_type === 'builder') 
                ? "Special Construction Deal by {$user->name}" 
                : "Exclusive Store Discount: {$user->name}";

            Offer::create([
                'user_id' => $user->id, // Linked to the specific vendor/builder
                'product_category_id' => $categories->random()->id ?? null,
                'title' => $title,
                'discount_tag' => rand(10, 50) . '% OFF',
                'coupon_code' => strtoupper(substr($user->name, 0, 3)) . rand(100, 999),
                'valid_until' => now()->addDays(rand(15, 60)),
                'description' => "Limited time offer provided by {$user->name}. Grab it before it expires!",
                'image' => 'offers/demo-banner.jpg', // Ensure this exists in storage/app/public/offers
                'is_active' => true, // Auto-approved for seeding
            ]);
        }
    }
}