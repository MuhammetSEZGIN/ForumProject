<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table("roles")->insert([
            ["name" => "author", "created_at" => now(), "updated_at" => now()],
            ["name" => "admin", "created_at" => now(), "updated_at" => now()],
            ["name" => "anonim", "created_at" => now(), "updated_at" => now()],
        ]);
        User::insert(
            ["name"=>"anonim", "email"=>"anonim@gmail.com", "password"=>"qwe", "created_at"=>now(), "updated_at"=>now(), "roleID"=>3],
        );
        User::create(
            ["name"=>"Muhammet", "email"=>"Muhammet@gmail.com", "password"=>"aDMIN%55Forum", "created_at"=>now(), "updated_at"=>now(), "roleID"=>2],
        );
        User::create(
            ["name"=>"admin", "email"=>"admin@admin.com", "password"=>"qwe", "created_at"=>now(), "updated_at"=>now(), "roleID"=>2],
        );
        Category::insert([
            ["categoryName" => "Yazılım", "created_at" => now(), "updated_at" => now()],
            ["categoryName" => "Donanım", "created_at" => now(), "updated_at" => now()],
            ["categoryName" => "Mobil Teknolojiler", "created_at" => now(), "updated_at" => now()],
            ["categoryName" => "Oyun Dünyası", "created_at" => now(), "updated_at" => now()],
            ["categoryName" => "Yapay Zeka", "created_at" => now(), "updated_at" => now()],
            ["categoryName" => "Siber Güvenlik", "created_at" => now(), "updated_at" => now()],
            ["categoryName" => "Ağ ve İnternet", "created_at" => now(), "updated_at" => now()],
            ["categoryName" => "Elektronik ve Robotik", "created_at" => now(), "updated_at" => now()],
            ["categoryName" => "Bilim ve Teknoloji", "created_at" => now(), "updated_at" => now()],
            ["categoryName" => "Diğer Teknolojik Konular", "created_at" => now(), "updated_at" => now()],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    /*
     * Rollback işlemi sırasında roles tablosundan author, admin ve anonim rolleri silinir.
     * Ama öncesinde foreign key check kapatılır ve işlem bittikten sonra tekrar açılır.
     * */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("roles")->whereIn("name", ["author", "admin", "anonim"])->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
