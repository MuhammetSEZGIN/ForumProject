<?php

namespace App\Http\Controllers;
use App\Helpers\UserLogEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Helpers\UserActionLogHelper;


class LoginController extends Controller{

    /*
     * Login sayfasını gösterir.
     * */
    public function index(){
        return view('auth.login');
    }

    /*
     * Login işlemini yapar. Yazar ve admin girişleri yapılabilir.
     * */
    public function login(Request $request)
    {

        $validatedData=$request->validate([
           "name" => "required",
           "password" => "required",
        ]);

        $control = Auth::attempt($validatedData);

        if(!$control){
            userActionLogHelper::logAction(UserLogEnum::LOGIN_FAIL, $request->all());
            throw ValidationException::withMessages([
                "fail"=>UserLogEnum::LOGIN_FAIL
            ]);
        }
        $request->session()->regenerate();

        if(Auth::user()->isAdmin()) {

            userActionLogHelper::logAction(UserLogEnum::LOGIN_ADMIN, $request->all());
            return redirect()->route('adminIndex')->with('success', UserLogEnum::LOGIN_ADMIN);
        }
        if (Auth::user()->isAuthor()) {
            userActionLogHelper::logAction(UserLogEnum::LOGIN_SUCCESS, $request->all());
            return redirect()->route('mainMenu')->with('success', UserLogEnum::LOGIN_SUCCESS);
        }
        return redirect('/');

    }

    /*
     * Çıkış işlemini yapar.
     */
    public function logout()
    {
        // başarı mesajları
        userActionLogHelper::logAction(UserLogEnum::LOGOUT, request()->all());
        Auth::logout();
        return redirect()->route('login')->with('success', UserLogEnum::LOGOUT);
    }
}
