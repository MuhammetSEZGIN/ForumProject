<?php

namespace App\Http\Middleware;

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
        DB::table('userlogs')->insert([
            'userID' => Auth::check()? Auth::id():null,
            'ip'=>$request->ip(),
            'url'=>$request->url(),
            'postData'=>json_encode($postData),
            'userAgent'=>$request->header('User-Agent'),
            'created_at'=>now(),
            'updated_at'=>now()
            // ????
        ]);

        return $response;
    }
}
