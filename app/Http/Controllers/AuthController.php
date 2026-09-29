<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * AuthController — menangani autentikasi pengguna (login, register, logout).
 */
class AuthController extends Controller
{
    /** @return \Illuminate\View\View Tampilkan halaman form login. */
    public function showLogin() { return view('auth.login'); }

    /**
     * Proses autentikasi pengguna.
     *
     * @param  Request                               $request Data login: email, password, remember.
     * @return \Illuminate\Http\RedirectResponse              Redirect ke dashboard jika berhasil.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))
                ->with('sukses', 'Selamat datang, ' . Auth::user()->name);
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    /** @return \Illuminate\View\View Tampilkan halaman form registrasi. */
    public function showRegister() { return view('auth.register'); }

    /**
     * Proses registrasi akun pengguna baru.
     *
     * @param  Request                               $request Data registrasi: name, email, password.
     * @return \Illuminate\Http\RedirectResponse              Redirect ke dashboard setelah auto-login.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        Auth::login($user);
        return redirect()->route('dashboard')->with('sukses', 'Registrasi berhasil!');
    }

    /**
     * Logout pengguna dan invalidasi sesi aktif.
     *
     * @param  Request                               $request
     * @return \Illuminate\Http\RedirectResponse              Redirect ke halaman utama.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('sukses', 'Anda telah logout.');
    }
}