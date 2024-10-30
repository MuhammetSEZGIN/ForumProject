<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'authorID' => \App\Models\User::factory(),
            'content' => $this->faker->paragraph,
            'title' => $this->faker->sentence,
            'viewCount' => $this->faker->randomNumber(1,10),
            'isActive' => $this->faker->boolean,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
