<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Song;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\\Models\\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(2),
            'duration' => $this->faker->numberBetween(120, 300), // duration in seconds
            'album_id' => null, // to be assigned when seeding
        ];
    }
}
