<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    // Method untuk menampilkan halaman login
    public function showLoginForm()
    {
        $hashedPassword = bcrypt('doni123');

        // echo $hashedPassword;
        return view('auth.login');
    }

    // Method untuk proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika login berhasil, set pesan sukses
            Session::flash('success', 'Login successful!');
            // Menyetel nilai session
            session(['status_login' => 'true']);
            // Jika autentikasi berhasil, redirect ke halaman beranda
            return redirect()->intended('/dashboard');
        }else{

            // Jika autentikasi gagal, kembali ke halaman login dengan pesan error
            return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
        }

    }
}
