<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories (Keep this!)
        $this->call(CategorySeeder::class);
        
        // 2. Users (Add this!)
        $this->call(UserSeeder::class);

        $this->call(PropertySeeder::class);

        // 3. Admin (Keep this!)
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
    }
}