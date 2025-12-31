<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Run Categories
        $this->call(CategorySeeder::class);

        // 2. Create Admin / Test User Safely
        // checks if email exists; if not, creates it.
        User::firstOrCreate(
            ['email' => 'admin@soilnwater.com'], // Check this email
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // Default Password
                'profile_type' => 'admin', // Assuming you have an admin type
                'email_verified_at' => now(),
            ]
        );

        // Optional: Create a default customer for testing
        User::firstOrCreate(
            ['email' => 'user@soilnwater.com'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password'),
                'profile_type' => 'customer',
            ]
        );
    }
}