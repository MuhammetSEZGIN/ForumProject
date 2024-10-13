<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Movies;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "body" => $this->faker->realText(),
            "userId"=> User::factory(),
            "movieId"=> Movie::factory(),
        ];
    }
}
