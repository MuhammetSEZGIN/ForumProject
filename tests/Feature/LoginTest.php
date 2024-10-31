<?php

namespace Tests\Feature;

use App\Helpers\UserLogEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    const ADMIN_USER_NAME = 'admin';
    const ADMIN_USER_PASSWORD = 'qwe';

    /**
     * A basic feature test example.
     */

    public function test_guest_can_view_login_form(): void
    {

        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }
    public function test_user_can_login_with_correct_information(): void
    {
        $user= User::factory()->create([
            'name' =>'test',
            'password' => bcrypt('password'),
            'roleID' => $this->getRole(1), // 1 author 2 admin
        ]);
        $response = $this->post('/login', [
            'name' => $user->name,
            'password' => 'password',
        ])->assertFound(); // 302 kodu döndürür. geçici yönlendirme anlamına gelir.

        $response->assertSessionHas('success', UserLogEnum::LOGIN_SUCCESS);
        $response->assertRedirect('/mainMenu');
        $this->actingAs($user);// auth kontrolü yapmadan önce  o anki kullanıcıyı olarak belirler
        $this->assertAuthenticatedAs($user); // Auth kontrol yapar
    }
    public function test_user_cannot_login_with_incorrect_password(): void
    {
        $user= User::factory()->make([
            'name' =>'test',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/login', [
            'name' => $user->name,
            'password' => 'password1',
        ]);
        $response->assertSessionHasErrors()->assertStatus(302);
        $response->assertInvalid();
     /*   $response->assertSessionHasErrors()->assertStatus(302);*/

    }

    public function test_user_can_logout(): void
    {

        $user= User::factory()->create([
            'name' =>'test',
            'password' => bcrypt('password'),
            'roleID' => $this->getRole(1), // 1 author 2 admin
        ]);
        $response = $this->post('/login', [
            'name' => $user->name,
            'password' => 'password',
        ]);
        $response->assertRedirect('/mainMenu');
        $this->actingAs($user);
        $response = $this->post('/logout');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_login_with_correct_information(): void
    {
        $adminUser = $this->getAdminUser();
        $response = $this->post('/login', [
            "name"=>$adminUser->name,
            "password"=>self::ADMIN_USER_PASSWORD,    // admin şifresi database de şireli olduğu için post işlemi yapılırken şifreyi elle giriyorum ???
        ]);

        $response->assertRedirectToRoute('adminIndex');
        $this->actingAs($adminUser);
        $this->assertAuthenticatedAs($adminUser);
    }

    public function test_admin_cannot_login_with_incorrect_password(): void
    {
        $adminUser = $this->getAdminUser();
        $response = $this->post('/login', [
            "name"=>$adminUser->name,
            "password"=>'wrong_password',
        ]);
        $response->assertSessionHasErrors()->assertStatus(302);
    }


   protected function getAdminUser(){

       return  $user= User::factory()->create([
           'name' => self::ADMIN_USER_NAME,
           'password' => bcrypt(self::ADMIN_USER_PASSWORD),
           "roleID" => $this->getRole(2),
       ]);

   }


/*    getRole fonksiyonu ile role tablosuna 2 adet kayıt eklenir.
    * 1. kayıt author
    * 2. kayıt admin
   */

   protected function getRole($roleID=1)
   {

       if(!Role::where('id', 1)->exists()){
           Role::create([
               'id' => 1,
               'name' => 'author',
           ]);
       }
       if (!Role::where('id', 2)->exists()){
           Role::create([
               'id' => 2,
               'name' => 'admin',
           ]);
       } if (!Role::where('id', 3)->exists()){
           Role::create([
               'id' => 3,
               'name' => 'anonim',
           ]);
       }
       if(!User::where('id',1)->exists()) {
              User::create(["name"=>"anonim", "email"=>"anonim@gmail.com", "password"=>"qwe", "created_at"=>now(), "updated_at"=>now(), "roleID"=>3]);
       }
         return $roleID;

   }
}
