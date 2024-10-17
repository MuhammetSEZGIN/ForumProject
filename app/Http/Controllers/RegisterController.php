<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function index(): View
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        // dd(request()->all());
        $validatedAttribute=$request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:255|unique:users',   // eğer çalışıyorsa users sayfasında email in kayıtlı olup olmadığını kontrol eder
            'password' => 'required|string|min:3|confirmed', // password_confirmation
        ]);

        // bu neden ben de kızıyor
        $user=User::create($validatedAttribute);
        // şifreyi her türlü hash liyormuş zaten

//        DB::table('users')->insert([
//            'name'=>$request['name'],
//            'email'=>$request['email'],
//            'password'=>Hash::make($request['password']),
//            'email_verified_at' => now(),
//        ]);

        Auth::login($user);
        return redirect('mainMenu');
    }
}
