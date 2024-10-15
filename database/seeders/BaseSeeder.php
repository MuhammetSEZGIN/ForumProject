<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

       User::factory(6)->create();

        DB::table("roles")->insert([
            ["name" => "admin", "userID" => 1],
            ["name" => "author", "userID" => 2],
            ["name" => "author", "userID" => 3],
            ["name" => "author", "userID" => 4],
            ["name" => "author", "userID" => 5],
            ["name" => "author", "userID" => 6],


        ]);

        DB::table("categories")->insert([
           ["categoryName" => "PHP", "created_at" => now(), "updated_at" => now()],
           ["categoryName" => "Laravel", "created_at" => now(), "updated_at" => now()],
           ["categoryName" => "JavaScript", "created_at" => now(), "updated_at" => now()],
           ["categoryName" => "VueJS", "created_at" => now(), "updated_at" => now()],
           ["categoryName" => "ReactJS", "created_at" => now(), "updated_at" => now()],
           ["categoryName" => "Angular", "created_at" => now(), "updated_at" => now()],
       ]);

       DB::table("articles")->insert([
           [ "content" => "PHP Basics", "authorID" => 1, "created_at" => now(), "updated_at" => now()],
           [ "content" => "Laravel Basics", "authorID" => 2, "created_at" => now(), "updated_at" => now()],
           [ "content" => "JavaScript Basics", "authorID" => 3, "created_at" => now(), "updated_at" => now()],
           [ "content" => "VueJS Basics", "authorID" => 4, "created_at" => now(), "updated_at" => now()],
           ["content" => "ReactJS Basics", "authorID" => 5, "created_at" => now(), "updated_at" => now()],
           [ "content" => "Angular Basics", "authorID" => 6, "created_at" => now(), "updated_at" => now()],
       ]);

       DB::table("comments")->insert([
              ["content" => "Great Article", "articleID" => 1, "authorID" => 2, "created_at" => now(), "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 2, "authorID" => 3, "created_at" => now(), "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 3, "authorID" => 4, "created_at" => now(), "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 4, "authorID" => 5, "created_at" => now(), "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 5, "authorID" => 6, "created_at" => now(), "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 6, "authorID" => 1, "created_at" => now(), "updated_at" => now()],
         ]);

       DB::table("article__category")->insert([
           ["articleID" => 1, "categoryID" => 1, "created_at" => now(), "updated_at" => now()],
           ["articleID" => 2, "categoryID" => 2, "created_at" => now(), "updated_at" => now()],
           ["articleID" => 3, "categoryID" => 3, "created_at" => now(), "updated_at" => now()],
           ["articleID" => 4, "categoryID" => 4, "created_at" => now(), "updated_at" => now()],
           ["articleID" => 5, "categoryID" => 5, "created_at" => now(), "updated_at" => now()],
           ["articleID" => 6, "categoryID" => 6, "created_at" => now(), "updated_at" => now()],
       ]);

    }
}
