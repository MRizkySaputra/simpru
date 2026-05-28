<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;

Route::redirect('/', '/login');

// Rute Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-process', [AuthController::class, 'loginProcess']);

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register-process', [AuthController::class, 'registerProcess']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/register-success', function () {
    return view('auth.register-success');
});

Route::get('/forget-password', function () {
    return view('auth.forget-password');
});

Route::get('/forget-password-success', function () {
    return view('auth.forget-password-success');
});

use App\Http\Controllers\AdminController;

// ==========================================
// ADMIN ROUTES (Ruang Kendali SIMPRU)
// ==========================================
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/ruangan', [AdminController::class, 'ruangan']);
    Route::post('/ruangan/store', [AdminController::class, 'storeRuangan']);
    Route::delete('/ruangan/{id}', [AdminController::class, 'deleteRuangan']);
    Route::put('/ruangan/{id}', [AdminController::class, 'updateRuangan']);
    Route::get('/permohonan', [AdminController::class, 'permohonan']);
    Route::post('/detail-permohonan', [AdminController::class, 'prosesPermohonan']); // Untuk tombol Setujui/Tolak
    Route::get('/jadwal', [AdminController::class, 'jadwal']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/laporan', [AdminController::class, 'laporan']);
    Route::get('/permohonan', [AdminController::class, 'permohonan']);
    Route::get('/detail-permohonan/{id}', [AdminController::class, 'detailPermohonan']);
    Route::post('/proses-permohonan/{id}', [AdminController::class, 'prosesPermohonan']);
    
    // Rute statis
    Route::get('/notifikasi', function () { return view('admin.notifikasi'); });
    Route::get('/detail-permohonan', function () { return view('admin.detail-permohonan'); });
    Route::get('/roles', function () { return view('admin.roles'); });
    Route::get('/roles/create', function () { return redirect('/admin/roles'); });
    Route::get('/roles/edit', function () { return redirect('/admin/roles'); });
    Route::post('/roles/create', function () { return redirect('/admin/roles'); });
    Route::post('/roles/edit', function () { return redirect('/admin/roles'); });
});

// ==========================================
// USER ROUTES (Mahasiswa/Peminjam)
// ==========================================
Route::prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('/riwayat', [UserController::class, 'riwayat']);
    Route::get('/profil', [UserController::class, 'profil']);
    
    // Rute Booking / Ajukan
    Route::get('/ajukan', [BookingController::class, 'ajukan']);
    Route::get('/ajukan-detail', [BookingController::class, 'ajukanDetail']); // Mengarah ke Controller
    Route::post('/ajukan-proses', [BookingController::class, 'ajukanProses']);
    Route::post('/ajukan-konfirmasi', [BookingController::class, 'ajukanKonfirmasi']);
    Route::post('/ajukan-proses', [BookingController::class, 'ajukanProses']);
    
    // Rute statis tambahan
    Route::get('/ajukan-konfirmasi', function () { return view('user.ajukan-konfirmasi'); });
    Route::get('/riwayat-detail/{id}', [UserController::class, 'riwayatDetail']);
    Route::get('/notifikasi', [UserController::class, 'notifikasi']);
});