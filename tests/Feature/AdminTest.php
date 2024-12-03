<?php

namespace Tests\Feature;

use App\Helpers\AdminMessageEnum;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    const ADMIN_NAME = "admin";
    const ADMIN_ID = 2;

    /*
     * Admin admin.index sayfasını görebilir
     * */
    public function test_admin_can_view_index(): void
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin);
        $response = $this->get('/index');
        $response->assertStatus(200);
    }

    /*
     * Admin userLogs sayfasını görebilir
     * */
    public function test_admin_can_view_userLogs(): void
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin);
        UserLog::create([
            'userID' => $admin->id,
            'ip' => '127.0.0.1',
            'url' => 'test.com',
            'postData' => json_encode('Test Post Data'),
            'userAgent' => 'Test User Agent',
        ]);
        $response = $this->get(route('userLogs'));

        // AssertSessionHas ile sessionda success mesajı olup olmadığını kontrol edilir
        // Ama biz controller da session oluşturmadığımız için bu test hata verecektir
        // Bu yüzden assertViewHas ile view içindeki success mesajını kontrol ediyoruz

        $response->assertViewHas('success', AdminMessageEnum::VIEW_ALL_LOGS);
        $response->assertStatus(200);
    }

    /*
     * Admin userLogs silme işlemi yapabilir
     * */
    public function test_admin_can_delete_userLogs(): void
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin);
        UserLog::create([
            'userID' => $admin->id,
            'ip' => '127.0.0.1',
            'url' => 'test.com',
            'postData' => json_encode('Test Post Data'),
            'userAgent' => 'Test User Agent',
        ]);
        $userLog = UserLog::where('userID', $admin->id)->first();
        $response = $this->delete(route('userLogsDelete', $userLog->id));
        $response->assertRedirect(route('userLogs'));
        $response->assertStatus(302);
        $userLog = UserLog::where('userID', $admin->id)->first();
        $this->assertDatabaseMissing('userLogs', [
            'id' => $userLog->id,
            'userID' => $userLog->userID,
            'ip' => $userLog->ip,
            'url' => $userLog->url,
            'postData' => $userLog->postData,
            'userAgent' => $userLog->userAgent,
        ]);
        $response->assertSessionHas('success', AdminMessageEnum::USER_LOGS_DELETE_SUCCESS);
    }

    public function test_admin_can_delete_all_userLogs(): void
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin);
        UserLog::create([
            'userID' => $admin->id,
            'ip' => '127.0.0.1',
            'url' => 'test.com',
            'postData' => json_encode('Test Post Data'),
            'userAgent' => 'Test User Agent',
        ]);
        $response = $this->delete(route('userLogsDeleteAll'));
        $response->assertRedirect(route('userLogs'));
        $response->assertStatus(302);
        $response->assertSessionHas('success', AdminMessageEnum::USER_LOGS_DELETE_ALL_SUCCESS);
    }

    public function test_admin_can_view_all_users()
    {
        User::factory()->count(5)->create();
        $admin = $this->getAdmin();
        $this->actingAs($admin);
        $response = $this->get(route('allUsers'));
        $response->assertStatus(200);
        $response->assertViewHas('success', AdminMessageEnum::VIEW_ALL_USERS);
    }

    public function test_admin_can_delete_user()
    {
        $user = User::factory()->create();
        $admin = $this->getAdmin();
        $this->actingAs($admin);
        $response = $this->delete(route('userDelete', $user->id));
        $response->assertRedirect(route('allUsers'));
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
        $response->assertStatus(302);
        $response->assertSessionHas('success', AdminMessageEnum::USER_DELETE_SUCCESS);
    }


    protected function getAdmin()
    {
        return User::where('name', self::ADMIN_NAME)->where('id', self::ADMIN_ID)->first();
    }
}

