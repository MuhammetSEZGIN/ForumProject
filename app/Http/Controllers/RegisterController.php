<?php

namespace App\Http\Controllers;
use App\Helpers\UserActionLogHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Illuminate\View\View;

class RegisterController extends Controller
{

    /*
     * Kullanıcı kayıt sayfasını gösterir.
     * */
    public function index(): View
    {
        return view('auth.register');
    }

    /*
     * Kullanıcı kayıt işlemini yapar. Sadece yazar kaydı yapılabilir.
     * */
    public function register(Request $request)
    {
        $validatedAttribute=$request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:255|unique:users',   // eğer çalışıyorsa users sayfasında email in kayıtlı olup olmadığını kontrol eder
            'password' => 'required|string|min:3|confirmed', // password_confirmation
        ]);

        $roleId=Role::where('name','author')->first()->id;

        $user = User::create([
            'name' => $validatedAttribute['name'],
            'email' => $validatedAttribute['email'],
            'password' => $validatedAttribute['password'],
            'roleID' => $roleId,
        ]);

        // enum class ile kulalnıcı logları
        if($user){
            UserActionLogHelper::logAction("Kullanici kaydi", $request->all());
        }else{
            UserActionLogHelper::logAction("Kullanici kaydi basarisiz", $request->all());
        }
        Auth::login($user);
        // with success message
        return redirect('mainMenu');
    }
}
