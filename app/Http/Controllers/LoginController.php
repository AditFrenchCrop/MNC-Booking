<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 3. Logika Redirect Berdasarkan Role
            if ($user->role === 'superadmin') {
                return redirect()->intended('/superadmin/dashboard');
            } elseif ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        // 4. Jika gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
}