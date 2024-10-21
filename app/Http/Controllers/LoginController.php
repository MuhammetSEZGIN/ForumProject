<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Helpers\UserActionLogHelper;


class LoginController extends Controller{

    public function index(){
        return view('auth.login');
    }
    public function login(Request $request)
    {

        $validatedData=$request->validate([
           "name" => "required",
           "password" => "required",
        ]);

        $control = Auth::attempt($validatedData);
        if($control){
            $request->session()->regenerate();
            userActionLogHelper::logAction("Kullanici girisi", $request->all());
            return redirect('mainMenu');
       }else{
            userActionLogHelper::logAction("Yanlis giris denemesi", $request->all());
            throw ValidationException::withMessages([
               "name"=>"Kullanici adi ve şifre uyuşmuyor"
           ]);
        }


    }
    public function logout()
    {
        Auth::logout();
        userActionLogHelper::logAction("Kullanici cikisi", request()->all());
        return redirect('login');
    }
}
