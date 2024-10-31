<?php

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
        User::query()->create(
            ["name"=>"anonim", "email"=>"anonim@gmail.com", "password"=>"qwe", "created_at"=>now(), "updated_at"=>now(), "roleID"=>3],
        );
        User::query()->create(
            ["name"=>"admin", "email"=>"admin@admin.com", "password"=>"qwe", "created_at"=>now(), "updated_at"=>now(), "roleID"=>2],
        );
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
