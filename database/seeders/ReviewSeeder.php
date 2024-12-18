<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\SkateSpot;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // Ensure there are some skate spots and users to associate reviews with
        $users = User::all();
        $skateSpots = SkateSpot::all();

        if ($users->isEmpty() || $skateSpots->isEmpty()) {
            $this->command->info('No users or skate spots found. Skipping review seeding.');
            return;
        }

        // Create reviews for existing skate spots
        foreach ($skateSpots as $skateSpot) {
            Review::factory()->count(5)->create([
                'skate_spot_id' => $skateSpot->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
