<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'contributor' 
                ? redirect()->route('admin.stories.index') 
                : redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Handle login authentication.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'contributor') {
                return redirect()->route('admin.stories.index')->with('success', 'Selamat datang! Anda masuk sebagai Contributor.');
            }

            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Show forgot password request form.
     */
    public function showForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Mock sending reset password link.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Mock response
        return back()->with('status', 'Kami telah mengirimkan tautan atur ulang sandi ke email Anda!');
    }

    /**
     * Handle logging out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar.');
    }
}
