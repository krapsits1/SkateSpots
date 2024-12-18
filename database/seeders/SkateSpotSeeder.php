<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkateSpot;

class SkateSpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 skate spots
        SkateSpot::factory()->count(20)
        ->withImages(3)
        ->create();
    }
}
