<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\UserLog;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
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
        $user= User::factory()->make([
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
