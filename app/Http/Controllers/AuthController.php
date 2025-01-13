<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $login_type => $request->input('login'),
            'password' => $request->input('password'),
        ];

        Log::info('Attempting login with credentials:', $credentials);

        if (Auth::attempt($credentials)) {
            Log::info('Login successful for user:', ['user' => Auth::user()]);
            $request->session()->regenerate();
            Log::info('Session regenerated:', ['session' => $request->session()->all()]);
            return redirect()->intended('/dashboard');
        }

        Log::error('Login failed for credentials:', $credentials);

        return back()->with('error', 'Email/Username atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
