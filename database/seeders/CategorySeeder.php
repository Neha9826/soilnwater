<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str; // Import Str for slug generation

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Vendor Categories
        $vendors = ['Hardware Store', 'Tools & Machinery', 'Home Decor', 'Construction Material', 'Pumps & Motors', 'Electrical Supplies'];
        foreach ($vendors as $name) {
            Category::firstOrCreate(
                ['name' => $name, 'type' => 'vendor'], 
                [
                    'slug' => Str::slug($name), // <--- Added Slug
                    'is_active' => true
                ]
            );
        }

        // 2. Consultant Categories
        $consultants = ['Architect', 'Interior Designer', 'Vastu Consultant', 'Legal Advisor', 'Property Broker', 'Landscaper', 'Loan Agency'];
        foreach ($consultants as $name) {
            Category::firstOrCreate(
                ['name' => $name, 'type' => 'consultant'], 
                [
                    'slug' => Str::slug($name), // <--- Added Slug
                    'is_active' => true
                ]
            );
        }

        // 3. Hotel/Resort Categories
        $hospitality = ['Hotel', 'Resort', 'Homestay', 'Guest House'];
        foreach ($hospitality as $name) {
            Category::firstOrCreate(
                ['name' => $name, 'type' => 'hotel'], 
                [
                    'slug' => Str::slug($name), // <--- Added Slug
                    'is_active' => true
                ]
            );
        }

        // 4. Service Provider Categories
        $services = ['Plumber', 'Electrician', 'Carpenter', 'Painter', 'Cleaning Service', 'Appliance Repair', 'Contractor'];
        foreach ($services as $name) {
            Category::firstOrCreate(
                ['name' => $name, 'type' => 'service'], 
                [
                    'slug' => Str::slug($name), // <--- Added Slug
                    'is_active' => true
                ]
            );
        }
        
        // 5. Builder Categories
        $builders = ['Residential Developer', 'Commercial Builder', 'Civil Contractor'];
        foreach ($builders as $name) {
            Category::firstOrCreate(
                ['name' => $name, 'type' => 'builder'], 
                [
                    'slug' => Str::slug($name), // <--- Added Slug
                    'is_active' => true
                ]
            );
        }
    }
}