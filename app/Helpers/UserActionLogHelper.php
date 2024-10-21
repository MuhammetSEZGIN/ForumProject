<?php
namespace App\Helpers;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserActionLogHelper
{
    public static function logAction($action, $postData)
    {
        if(isset($postData['password'])) {
            $postData['password'] = '********';
        }
        if(isset($postData['password_confirmation'])) {
            $postData['password_confirmation'] = '********';
        }

        DB::table('userActionLogs')->insert([
                'userID' => Auth::check()? Auth::id():null,
                'action' => $action,
                'ip' => request()->ip(),
                'userAgent' => request()->userAgent(),
                'postData' => json_encode($postData),
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }
}
