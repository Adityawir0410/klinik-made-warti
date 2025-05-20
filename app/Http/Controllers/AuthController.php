<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login user.
     */
    public function login(Request $request)
    {
        // Validasi form login
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        // Coba autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // cegah session fixation

            return redirect()->route('dashboard.booking'); // redirect ke dashboard
        }

        // Jika gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Logout dan redirect ke halaman login.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate dan regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
