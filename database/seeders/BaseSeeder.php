<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function getTxtContent($path){
        try{
            return file_get_contents($path);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function run(): void
    {
       User::factory(6)->create();

        DB::table("categories")->insert([
           ["categoryName" => "PHP", "created_at" => now(), "updated_at" => now()],
           ["categoryName" => "Laravel", "created_at" => now(), "updated_at" => now()],
           ["categoryName" => "JavaScript", "created_at" => now(), "updated_at" => now()],
           ["categoryName" => "VueJS", "created_at" => now(), "updated_at" => now()],
           ["categoryName" => "ReactJS", "created_at" => now(), "updated_at" => now()],
           ["categoryName" => "Angular", "created_at" => now(), "updated_at" => now()],
       ]);

       DB::table("articles")->insert([
           [ "content" =>$this->getTxtContent("public/SeedContent/loremContent.txt") , "authorID" => 1,"title"=>"Birinci Yazi","viewCount"=>1,"isActive"=>true, "created_at" => now(), "updated_at" => now()],
           [ "content" => $this->getTxtContent("public/SeedContent/loremContent.txt"), "authorID" => 2,"title"=>"İkinci yazi","viewCount"=>2 ,"isActive"=>true,"created_at" => now(), "updated_at" => now()],
           [ "content" => $this->getTxtContent("public/SeedContent/loremContent.txt"), "authorID" => 3,"title"=>"Ucuncu Yazi","viewCount"=>3 ,"isActive"=>true,"created_at" => now(), "updated_at" => now()],
           [ "content" => $this->getTxtContent("public/SeedContent/loremContent.txt"), "authorID" => 4,"title"=>"Dorduncu Yazi","viewCount"=>1,"isActive"=>true, "created_at" => now(), "updated_at" => now()],
           ["content" => $this->getTxtContent("public/SeedContent/loremContent.txt"), "authorID" => 5,"title"=>"Besinci Yazi","viewCount"=>4,"isActive"=>true, "created_at" => now(), "updated_at" => now()],
           [ "content" => $this->getTxtContent("public/SeedContent/loremContent.txt"), "authorID" => 6,"title"=>"Altinci Yazi","viewCount"=>5,"isActive"=>true, "created_at" => now(), "updated_at" => now()],
       ]);

       DB::table("comments")->insert([
              ["content" => "Great Article", "articleID" => 1,"userID"=>"2", "created_at" => now(),"isApproved"=>true, "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 2,"userID"=>"3", "created_at" => now(),"isApproved"=>true, "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 3,"userID"=>"4", "created_at" => now(),"isApproved"=>true, "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 4,"userID"=>"1", "created_at" => now(),"isApproved"=>true, "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 5,"userID"=>"1", "created_at" => now(),"isApproved"=>true, "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 6,"userID"=>"3", "created_at" => now(),"isApproved"=>true, "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 1,"userID"=>"3", "created_at" => now(),"isApproved"=>true, "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 1,"userID"=>"3", "created_at" => now(),"isApproved"=>true, "updated_at" => now()],
              ["content" => "Great Article", "articleID" => 1,"userID"=>"3", "created_at" => now(),"isApproved"=>true, "updated_at" => now()],

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
