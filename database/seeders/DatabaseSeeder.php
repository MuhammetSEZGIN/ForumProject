<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

      User::factory(20)->create();
      Genre::factory(20)->create();
      Director::factory(20)->create();
      Movie::factory(20)->create();
      Comment::factory(20)->create();

    }
}
