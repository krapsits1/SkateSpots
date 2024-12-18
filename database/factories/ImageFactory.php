<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\SkateSpot;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get all image files from the storage directory
        $imageFiles = Storage::files('public/skate_spots');

        // Pick a random image file
        $randomImage = $this->faker->randomElement($imageFiles);

        return [
            'path' => str_replace('public/', '', $randomImage), // Remove 'public/' prefix
            'skate_spot_id' => SkateSpot::factory(),
        ];
    }
}