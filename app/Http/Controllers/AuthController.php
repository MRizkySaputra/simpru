<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/user/dashboard');
            }
        }

        return back()->with('error', 'Nama pengguna atau kata sandi salah!');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email:rfc,dns|unique:users,email',
            'id_number'             => 'required|string|unique:users,identity_number',
            'role'                  => 'required|string',
            'password'              => 'required|string|min:8|confirmed',
        ], [
            'name.required'         => 'Nama lengkap tidak boleh kosong.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid atau domain tidak ditemukan.',
            'email.unique'          => 'Email ini sudah terdaftar.',
            'id_number.required'    => 'NIM/NIDN wajib diisi.',
            'id_number.unique'      => 'NIM/NIDN ini sudah terdaftar.',
            'role.required'         => 'Silakan pilih peran/jabatan Anda.',
            'password.required'     => 'Kata sandi tidak boleh kosong.',
            'password.min'          => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = \App\Models\User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'identity_number' => $validated['id_number'],
            'role'            => $validated['role'],
            'password'        => bcrypt($validated['password']),
            'is_active'       => true,
        ]);

        return redirect('/register-success')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
