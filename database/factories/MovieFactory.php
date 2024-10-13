<?php

namespace Database\Factories;



use App\Models\Director;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    public function definition() :array
    {
        return [
            'title' => $this->faker->sentence(),
            'director_id' => Director::factory(),
            'imdb'=> $this->faker->randomDigit(),
        ];
    }
}
