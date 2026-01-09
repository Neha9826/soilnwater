<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // The 5 roles we need to populate
        $roles = ['vendor', 'consultant', 'hotel', 'builder', 'service'];

        foreach ($roles as $role) {
            // Create 3 users for each role
            for ($i = 1; $i <= 3; $i++) {
                
                $email = "{$role}{$i}@test.com"; // e.g., vendor1@test.com
                
                // 1. Create the User
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => ucfirst($role) . " User {$i}",
                        'password' => Hash::make('password'), // Default password
                        'profile_type' => $role,
                        'email_verified_at' => now(),
                    ]
                );

                // 2. Create the associated Business Profile
                // We use firstOrCreate to avoid duplicate business entries if you run this twice
                Business::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'name' => ucfirst($role) . " Company {$i}", // e.g., Vendor Company 1
                        'type' => $role,
                        'about_text' => 'We provide the best services in the market.',
                        'email' => $email,
                        'phone' => '987654321' . $i,
                        'contact_person' => "Manager {$i}",
                        'address' => "Block {$i}, Test Street",
                        'city' => 'Dehradun',
                        'state' => 'Uttarakhand',
                        'country' => 'India',
                        'pincode' => '248001',
                        'description' => "This is a dummy description for {$role} number {$i}.",
                        'is_verified' => true, // Auto-verify them for easier testing
                        'logo' => null, // Optional
                    ]
                );
            }
        }
    }
}