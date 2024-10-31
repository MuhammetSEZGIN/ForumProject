<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use App\Models\UserLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserLogs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    /*
     * Kullanıcının yaptığı istekleri loglamak için kullanılır.
     * Site içerisinde yapılan her isteği loglar. Kullanıcı girişi yapılmasza anonim kullanıcı olarak loglama yapar.
     * Booststrap app klasörü içerisindeki withMiddleware olarak eklenmiştir route fonksiyonlarına eklenmesi gerekmez.
     *
     * */
    public function handle(Request $request, Closure $next): Response
    {
        $response=$next($request);
        $postData = $request->all();

        if(isset($postData['password'])){
            $postData['password']='***';
        }
        if(isset($postData['password_confirmation'])){
            $postData['password_confirmation']='***';
        }
        /*
        if(Auth::id()==null){
            $role=Role::firstOrCreate(['name' => 'anonim',]);
            $user= User::factory()->firstOrCreate([
                'id'=>1,
                'name' =>'anonim',
                'password' => bcrypt('password'),
                'roleID' => $role->id,
            ]);
        }*/
        UserLog::create([
            'userID' => Auth::check()? Auth::id():1,
            'ip'=>$request->ip(),
            'url'=>$request->url(),
            'postData'=>json_encode($postData),
            'userAgent'=>$request->header('User-Agent'),
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        return $response;
    }
}
