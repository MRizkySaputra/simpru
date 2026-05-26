<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form login
    public function login()
    {
        return view('auth.login');
    }

    // Memproses form login
    public function loginProcess(Request $request)
    {

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        // ... (biarkan sisa kode di bawahnya apa adanya)

        // 2. Coba login (Cek apakah yang diinput itu email)
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            // 3. Cek role, lempar ke dashboard yang sesuai
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/user/dashboard');
            }
        }

        // Jika gagal login
        return back()->with('error', 'Nama pengguna atau kata sandi salah!');
    }

    // Menampilkan form register
    public function register()
    {
        return view('auth.register');
    }

    // Memproses pendaftaran
    public function registerProcess(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'id_number' => 'required|string',
            'role' => 'required|string',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nim_nidn' => $validated['id_number'],
        ]);

        return redirect('/register-success');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}