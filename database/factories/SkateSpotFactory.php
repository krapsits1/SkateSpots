<?php

namespace Database\Factories;

use App\Models\SkateSpot;
use App\Models\User;
use App\Models\Image; // Import the Image class
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SkateSpot>
 */
class SkateSpotFactory extends Factory
{
    protected $model = SkateSpot::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'category' => $this->faker->randomElement(['skatepark', 'skate_shop', 'street_spot']),
            'user_id' => User::factory(),
            'status' => 'pending',
        ];
    }

    /**
     * Indicate that the skate spot should have images.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withImages(int $count = 3)
    {
        return $this->has(Image::factory()->count($count), 'images');
    }
    
}
