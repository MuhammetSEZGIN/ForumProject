<?php
namespace App\Helpers;
use App\Models\UserActionLog;
use App\Models\UserLog;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserActionLogHelper
{

    /*
    Site içierisinde kullanıcıların belirlenen işlemlerini loglamak için kullanılır.
    Action parametresi UserLogEnum içerisinde tanımlı olan değerlerden biri olmalıdır.
    PostData parametresi ise loglanacak olan verileri içerir.

    */
    public static function logAction($action, $postData)
    {
        // Eğer postData içerisinde password veya password_confirmation varsa bu alanları gizler.

        if(isset($postData['password'])) {
            $postData['password'] = '********';
        }
        if(isset($postData['password_confirmation'])) {
            $postData['password_confirmation'] = '********';
        }

        // Kullanıcı loglarını tutmak için UserLog tablosuna kayıt atar.
        UserActionLog::create([
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
