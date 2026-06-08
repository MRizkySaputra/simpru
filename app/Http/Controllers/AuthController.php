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
        // 1. Validasi sangat ketat di server
        // 1. Validasi sangat ketat di server
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            // Tambahkan :rfc,dns di bawah ini
            'email'                 => 'required|email:rfc,dns|unique:users,email',
            'id_number'             => 'required|string|unique:users,identity_number',
            'role'                  => 'required|string',
            'password'              => 'required|string|min:8|confirmed', 
        ], [
            'name.required'         => 'Nama lengkap tidak boleh kosong.',
            'email.required'        => 'Email wajib diisi.',
            // Tambahkan pesan error format email ini
            'email.email'           => 'Format email tidak valid atau domain tidak ditemukan.',
            'email.unique'          => 'Email ini sudah terdaftar.',
            'id_number.required'    => 'NIM/NIDN wajib diisi.',
            'id_number.unique'      => 'NIM/NIDN ini sudah terdaftar.',
            'role.required'         => 'Silakan pilih peran/jabatan Anda.',
            'password.required'     => 'Kata sandi tidak boleh kosong.',
            'password.min'          => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // 2. Simpan ke database
        $user = \App\Models\User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'identity_number' => $validated['id_number'],
            'role'            => $validated['role'],
            'password'        => bcrypt($validated['password']),
            'is_active'       => true, 
        ]);

        // 3. Arahkan ke halaman sukses
        return redirect('/register-success')->with('success', 'Akun berhasil dibuat!');
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