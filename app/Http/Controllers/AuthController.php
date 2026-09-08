<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBerdasarkanRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectBerdasarkanRole(Auth::user()->role);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Menampilkan form pendaftaran
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses Pendaftaran (Public otomatis jadi 'user')
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Aturan mutlak: Public selalu mendaftar sebagai User
            'status' => 'aktif',
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    // Proses Logout (Kembali ke beranda)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Helper Fungsi Redirect
    private function redirectBerdasarkanRole($role)
    {
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($role === 'operator') {
            return redirect()->route('operator.dashboard');
        }

        return redirect()->route('user.dashboard');
    }
}
