<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyFloor;
use App\Models\Amenity;
use App\Models\User;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    public function run()
    {
        // 1. Find the specific user 'builder1@test.com'
        $user = User::where('email', 'builder1@test.com')->first();

        // Safety check: if user doesn't exist, stop.
        if (!$user) {
            $this->command->error("User 'builder1@test.com' not found! Please create this user first or check your import.");
            return;
        }

        $this->command->info("Seeding properties for user: " . $user->name);

        // 2. Ensure Amenities exist
        $amenities = ['WiFi', 'Parking', 'Swimming Pool', 'Gym', '24/7 Security', 'Power Backup', 'Balcony', 'Garden', 'CCTV', 'Lift'];
        foreach ($amenities as $name) {
            Amenity::firstOrCreate(['name' => $name]);
        }
        
        $allAmenityIds = Amenity::pluck('id');

        // --- PROPERTY 1: Luxury Apartment (Sale) ---
        $prop1 = Property::create([
            'user_id' => $user->id,
            'title' => '3BHK Luxury Apartment in Rajpur Road',
            'slug' => Str::slug('3BHK Luxury Apartment-' . uniqid()),
            'description' => 'A stunning fully furnished apartment with a mountain view. Located in the heart of the city.',
            'price' => 8500000,
            'type' => 'Apartment',
            'listing_type' => 'Sale',
            'address' => '12/A, Rajpur Road, Near Clock Tower',
            'city' => 'Dehradun',
            'state' => 'Uttarakhand',
            'images' => ['properties/demo/apt1.jpg', 'properties/demo/apt2.jpg'], 
            'videos' => [],
            'documents' => [],
            'google_map_link' => 'https://goo.gl/maps/example',
            'google_embed_link' => '<iframe src="https://www.google.com/maps/embed?pb=..."></iframe>',
            'is_active' => true,
        ]);
        
        PropertyFloor::create([
            'property_id' => $prop1->id,
            'floor_name' => 'Layout Plan',
            'area_sqft' => '1800',
            'rooms' => 3,
            'description' => 'Master bedroom with attached balcony and modular kitchen.',
        ]);
        
        $prop1->amenities()->attach($allAmenityIds->random(4));

        // --- PROPERTY 2: Modern Villa (Sale) ---
        $prop2 = Property::create([
            'user_id' => $user->id,
            'title' => 'Independent Villa with Private Garden',
            'slug' => Str::slug('Independent Villa-' . uniqid()),
            'description' => 'Spacious 4BHK villa with private parking, lawn, and servant quarters.',
            'price' => 25000000,
            'type' => 'Villa',
            'listing_type' => 'Sale',
            'address' => 'Vasant Vihar, Phase 2',
            'city' => 'Dehradun',
            'state' => 'Uttarakhand',
            'images' => ['properties/demo/villa1.jpg'],
            'is_active' => true,
        ]);

        PropertyFloor::create([
            'property_id' => $prop2->id,
            'floor_name' => 'Ground Floor',
            'area_sqft' => '2200',
            'rooms' => 2,
            'description' => 'Large living area, dining, kitchen, and guest bedroom.',
        ]);
        PropertyFloor::create([
            'property_id' => $prop2->id,
            'floor_name' => 'First Floor',
            'area_sqft' => '1800',
            'rooms' => 3,
            'description' => '3 Bedrooms with attached washrooms and terrace access.',
        ]);

        $prop2->amenities()->attach($allAmenityIds->random(5));

        // --- PROPERTY 3: Commercial Space (Rent) ---
        $prop3 = Property::create([
            'user_id' => $user->id,
            'title' => 'Premium Office Space on Main Highway',
            'slug' => Str::slug('Premium Office-' . uniqid()),
            'description' => 'Ready to move office space, suitable for IT companies or Banks.',
            'price' => 150000, 
            'type' => 'Commercial',
            'listing_type' => 'Rent',
            'address' => 'Haridwar Bypass Road',
            'city' => 'Dehradun',
            'state' => 'Uttarakhand',
            'images' => ['properties/demo/office1.jpg'],
            'is_active' => true,
        ]);
        
        $prop3->amenities()->attach($allAmenityIds->random(3));

        // --- PROPERTY 4: Residential Plot (Sale) ---
        $prop4 = Property::create([
            'user_id' => $user->id,
            'title' => 'Sunny Plot with Mussoorie View',
            'slug' => Str::slug('Sunny Plot-' . uniqid()),
            'description' => 'East facing plot in a gated society. Water and electricity connection available.',
            'price' => 4500000,
            'type' => 'Plot',
            'listing_type' => 'Sale',
            'address' => 'Sahastradhara Road',
            'city' => 'Dehradun',
            'state' => 'Uttarakhand',
            'images' => ['properties/demo/plot1.jpg'],
            'is_active' => true,
        ]);

        // --- PROPERTY 5: Share a Space (Co-living) ---
        $prop5 = Property::create([
            'user_id' => $user->id,
            'title' => 'Co-living Space for Students/Professionals',
            'slug' => Str::slug('Co-living Space-' . uniqid()),
            'description' => 'Shared room with high-speed wifi and meals included. Very close to universities.',
            'price' => 8000,
            'type' => 'Apartment',           
            'listing_type' => 'Share a Space', 
            'address' => 'Prem Nagar, Near UPES',
            'city' => 'Dehradun',
            'state' => 'Uttarakhand',
            'images' => ['properties/demo/pg1.jpg'],
            'is_active' => true,
        ]);
        
        $prop5->amenities()->attach($allAmenityIds->random(6));

        $this->command->info('Successfully seeded 5 properties for user: builder1@test.com!');
    }
}