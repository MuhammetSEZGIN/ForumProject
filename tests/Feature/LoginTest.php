<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_user_can_view_login_form(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    public function test_user_can_post_login_form(): void
    {
        $user= User::factory()->create([
            'name' =>'test',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/login', [
            'name' => $user->name,
            'password' => 'password',
        ]);
        $this->actingAs($user)->get('/login');
        $response->assertRedirect('/mainMenu');
    }

}
