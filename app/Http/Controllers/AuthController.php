<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        sleep(1);

        $credentials = $request->validate([
            'name'=> ['required', 'max:255'],
            'email' => ['email', 'unique:users', 'required', 'lowercase'],
            'password' => ['required','confirmed', 'min:8']
        ]);

        $user = User::create($credentials);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');


    }

    public function Login(Request $request){
        $credentials = $request->validate([
            'email' => ['email', 'exists:users', 'required', 'lowercase'],
            'password' => ['required', 'min:8']
        ]);

        if(Auth::attempt($credentials, $request->boolean('remember'))){
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email'=> 'The provided credentials do not matched our records.'
        ])->onlyInput('email');
    }


    public function Logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');

    }
}
