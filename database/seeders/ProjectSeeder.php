<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;
use App\Models\Amenity;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Find the User
        $user = User::where('email', 'regularUser@gmail.com')->first();

        if (!$user) {
            $this->command->error("User 'regularUser@gmail.com' not found! Please create this user first.");
            return;
        }

        // 2. Ensure we have some amenities
        $amenities = Amenity::inRandomOrder()->limit(5)->get();
        if ($amenities->isEmpty()) {
            $amenityNames = ['24/7 Security', 'Power Backup', 'Clubhouse', 'Swimming Pool', 'Gym', 'Park', 'Vastu Compliant'];
            foreach ($amenityNames as $name) {
                Amenity::create(['name' => $name]);
            }
            $amenities = Amenity::all();
        }

        // 3. Define Dummy Projects
        $projects = [
            [
                'title' => 'Sunrise Valley Plots',
                'description' => 'Premium residential plots located in the heart of the valley with scenic views and wide roads.',
                'price' => 2500000,
                'type' => 'Land / Plot',
                'project_status' => 'Upcoming',
                'city' => 'Dehradun',
                'state' => 'Uttarakhand',
                'address' => 'Sahastradhara Road, Near Helipad',
                'images' => [], // Empty for now, or add dummy paths like ['projects/images/dummy1.jpg']
            ],
            [
                'title' => 'Green Heights Society',
                'description' => 'A luxury apartment society offering 2BHK and 3BHK flats with modern amenities.',
                'price' => 6500000,
                'type' => 'Apartment Society',
                'project_status' => 'Under Construction',
                'city' => 'Dehradun',
                'state' => 'Uttarakhand',
                'address' => 'Rajpur Road, Civil Lines',
                'images' => [],
            ],
            [
                'title' => 'Royal Palms Villas',
                'description' => 'Exclusive gated community villas ready to move in. Experience luxury living.',
                'price' => 12000000,
                'type' => 'Villa Community',
                'project_status' => 'Ready to Move',
                'city' => 'Mussoorie',
                'state' => 'Uttarakhand',
                'address' => 'Mall Road Extension',
                'images' => [],
            ],
        ];

        // 4. Loop and Create
        foreach ($projects as $data) {
            $project = Project::create([
                'user_id' => $user->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title'] . '-' . uniqid()),
                'description' => $data['description'],
                'price' => $data['price'],
                'type' => $data['type'],
                'project_status' => $data['project_status'],
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'images' => $data['images'], // Array will be cast to JSON automatically
                'is_active' => true,
            ]);

            // Attach random amenities
            $project->amenities()->attach($amenities->random(3)->pluck('id'));
        }

        $this->command->info('Projects seeded successfully for ' . $user->email);
    }
}