<?php

namespace App\Http\Controllers;
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
            userActionLogHelper::logAction("Yanlis giris denemesi", $request->all());
            throw ValidationException::withMessages([
                "name"=>"Kullanici adi ve şifre uyuşmuyor"
            ]);
        }
        $request->session()->regenerate();

        if(Auth::user()->isAdmin()) {

            userActionLogHelper::logAction("Admin girisi", $request->all());
            return redirect()->route('adminIndex');
        }
        if (Auth::user()->isAuthor()) {
            userActionLogHelper::logAction("Yazar girisi", $request->all());
            return redirect('mainMenu');
        }
        return redirect('/');

    }

    /*
     * Çıkış işlemini yapar.
     */
    public function logout()
    {
        // başarı mesajları
        Auth::logout();
        userActionLogHelper::logAction("Kullanici cikisi", request()->all());
        return redirect('login')->with('success', 'Başarıyla çıkış yaptınız');
    }
}
