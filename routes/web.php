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
    Route::post('/users/store', [AdminController::class, 'storeUser']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::put('/users/{id}/role', [AdminController::class, 'changeRole']);
    Route::put('/users/{id}/toggle-status', [AdminController::class, 'toggleStatus']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    Route::get('/settings', [AdminController::class, 'settings']);
    Route::get('/notifikasi', [AdminController::class, 'notifikasi']);
    Route::get('/roles', [\App\Http\Controllers\AdminController::class, 'roles']);
    Route::post('/roles/store', [\App\Http\Controllers\AdminController::class, 'storeRole']);
    Route::put('/roles/{id}', [\App\Http\Controllers\AdminController::class, 'updateRole']);
    Route::delete('/roles/{id}', [\App\Http\Controllers\AdminController::class, 'deleteRole']);
    Route::get('/settings', [\App\Http\Controllers\AdminController::class, 'settings']);
    Route::post('/settings', [\App\Http\Controllers\AdminController::class, 'updateSettings']); // Rute baru untuk simpan
    // Rute Eksekusi Sistem & Zona Berbahaya
    Route::post('/settings/clear-cache', [\App\Http\Controllers\AdminController::class, 'clearCache']);
    Route::post('/settings/backup', [\App\Http\Controllers\AdminController::class, 'createBackup']);
    Route::post('/settings/maintenance', [\App\Http\Controllers\AdminController::class, 'toggleMaintenance']);
    Route::post('/settings/reset-data', [\App\Http\Controllers\AdminController::class, 'resetData']);
    Route::post('/settings/factory-reset', [\App\Http\Controllers\AdminController::class, 'factoryReset']);
    
});

// ==========================================
// USER ROUTES (Mahasiswa/Peminjam)
// ==========================================
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('/riwayat', [UserController::class, 'riwayat']);
    Route::get('/profil', [UserController::class, 'profil']);
    
    // Rute Booking / Ajukan
    Route::get('/ajukan', [BookingController::class, 'ajukan']);
    Route::get('/ajukan-detail', [BookingController::class, 'ajukanDetail']);
    Route::post('/ajukan-proses', [BookingController::class, 'ajukanProses']);
    Route::post('/ajukan-konfirmasi', [BookingController::class, 'ajukanKonfirmasi']);
    
    // Rute statis tambahan
    Route::get('/ajukan-konfirmasi', function () { return view('user.ajukan-konfirmasi'); });
    Route::get('/riwayat-detail/{id}', [UserController::class, 'riwayatDetail']);
    Route::get('/riwayat-detail/{id}/cetak', [UserController::class, 'cetakBukti']);
    Route::get('/notifikasi', [UserController::class, 'notifikasi']);
});