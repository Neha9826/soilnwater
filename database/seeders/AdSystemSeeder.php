<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdSystemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tiers
        $squareId = DB::table('ad_tiers')->where('code', 'square')->value('id');
        if (!$squareId) {
            $squareId = DB::table('ad_tiers')->insertGetId([
                'name' => 'Standard Square', 'code' => 'square', 'price' => 500.00, 'width_units' => 1, 'height_units' => 1
            ]);
        }

        // 2. Templates - FORCING UPDATE of required_fields
        
        // Modern Furniture
        DB::table('ad_templates')->updateOrInsert(
            ['name' => 'Modern Furniture', 'ad_tier_id' => $squareId],
            [
                'view_component' => 'ads.templates.furniture-square',
                // Added: phone, address, website
                'required_fields' => json_encode(['headline', 'subheadline', 'description', 'cta_text', 'phone', 'address', 'website', 'image']),
                'thumbnail' => 'templates/thumb_furniture.png'
            ]
        );

        // Beauty Clinic
        DB::table('ad_templates')->updateOrInsert(
            ['name' => 'Beauty Clinic', 'ad_tier_id' => $squareId],
            [
                'view_component' => 'ads.templates.beauty-square',
                'required_fields' => json_encode(['subheadline', 'title_1', 'title_2', 'service_1', 'service_2', 'service_3', 'phone', 'website', 'image_1', 'image_2', 'image_3']),
                'thumbnail' => 'templates/thumb_beauty.png'
            ]
        );

        // Grand Opening
        DB::table('ad_templates')->updateOrInsert(
            ['name' => 'Grand Opening', 'ad_tier_id' => $squareId],
            [
                'view_component' => 'ads.templates.restaurant-square',
                'required_fields' => json_encode(['headline', 'subheadline', 'date', 'time', 'address', 'website', 'image_1', 'image_2', 'image_3']),
                'thumbnail' => 'templates/thumb_restaurant.png'
            ]
        );
    }
}