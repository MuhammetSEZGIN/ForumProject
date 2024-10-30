<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_user_can_view_register_form(): void{
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function test_user_can_register_with_correct_information(): void
    {
        $user= User::factory()->make([
            'name' =>'test',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect('mainMenu');
        // Assert that no validation errors are present..
        $response->assertValid();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

    }
    public function test_user_cannot_register_with_email_that_is_already_taken(): void
    {
        $duplicatedUser= User::factory()->create([
            'name' =>'test',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/register', [
            'name' => 'test',
            'email' => $duplicatedUser->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'RoleID' => Role::where('name','author')->first()->id,
        ]);
        $response->assertInValid([ 'email']);
        /* $response->assertSessionHasErrors(['email'])->assertStatus(302);*/
    }
}
