<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Car;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('mainpage');
        }
        return view('auth.login');
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('mainpage');
        }
        return view('auth.register', ['users' => User::get()]);
    }

    public function authenticateRegister(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|min:4',
            'surname' => 'required|min:4',
            'mail' => 'required|unique:users|min:4',
            'password' => 'confirmed|required|min:4',
            'username' => 'required|unique:users|min:4',
        ]);


        $credentials['password'] = Hash::make($credentials['password']);

        $user = User::create($credentials);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('mainpage');
        }
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('mainpage');
        }

        return back()->withErrors([
            'username' => 'Podane dane są nieprawidłowe.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('mainpage');
    }
}
