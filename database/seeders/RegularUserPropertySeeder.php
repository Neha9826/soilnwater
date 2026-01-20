<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Str;

class RegularUserPropertySeeder extends Seeder
{
    public function run()
    {
        // 1. Get or Create the Regular User
        $user = User::firstOrCreate(
            ['email' => 'regularUser@gmail.com'],
            [
                'name' => 'Regular Customer',
                'password' => bcrypt('password'), // Default password
                'profile_type' => 'customer',     // Ensure they are a customer
                'email_verified_at' => now(),
            ]
        );

        // 2. Property 1: Rent a House (Residential)
        Property::create([
            'user_id' => $user->id,
            'title' => '3BHK Villa with Garden in Rajpur',
            'slug' => Str::slug('3BHK Villa with Garden in Rajpur-' . uniqid()),
            'description' => 'A beautiful independent villa with a private garden, modular kitchen, and 2 car parking spaces. Located in a peaceful society.',
            'price' => 25000, // Monthly Rent
            
            // Classification
            'type' => 'Villa',
            'listing_type' => 'Rent',
            'poster_type' => 'Owner',
            'is_govt_registered' => true,
            
            // Location
            'address' => '12/B, Green Valley Society, Rajpur Road',
            'city' => 'Dehradun',
            'state' => 'Uttarakhand',
            'google_map_link' => 'https://goo.gl/maps/example1',
            
            // Status
            'is_active' => true,
            
            // Dummy Images (Ensure you have a placeholder or handle nulls in view)
            'images' => ['properties/customer/house_dummy.jpg'] 
        ]);

        // 3. Property 2: Share an Office Space (Co-working)
        Property::create([
            'user_id' => $user->id,
            'title' => 'Dedicated Desk in IT Park',
            'slug' => Str::slug('Dedicated Desk in IT Park-' . uniqid()),
            'description' => 'Premium co-working space available. High-speed wifi, AC, coffee machine, and meeting rooms included in the price.',
            'price' => 4500, // Price per seat
            
            // Classification
            'type' => 'Commercial',
            'listing_type' => 'Share a Space',
            'poster_type' => 'Broker', // Testing broker selection
            'is_govt_registered' => false,
            
            // Location
            'address' => 'IT Park, Sahastradhara Road',
            'city' => 'Dehradun',
            'state' => 'Uttarakhand',
            
            // Status
            'is_active' => true,
            
            'images' => ['properties/customer/office_dummy.jpg']
        ]);

        $this->command->info('Test properties created for regularUser@gmail.com');
    }
}