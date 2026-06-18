<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-process', [AuthController::class, 'loginProcess']);

    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register-process', [AuthController::class, 'registerProcess']);

    Route::get('/register-success', fn() => view('auth.register-success'));
    Route::get('/forget-password', fn() => view('auth.forget-password'));
    Route::get('/forget-password-success', fn() => view('auth.forget-password-success'));
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/ruangan', [AdminController::class, 'ruangan']);
    Route::post('/ruangan/store', [AdminController::class, 'storeRuangan']);
    Route::put('/ruangan/{id}', [AdminController::class, 'updateRuangan']);
    Route::delete('/ruangan/{id}', [AdminController::class, 'deleteRuangan']);

    Route::get('/permohonan', [AdminController::class, 'permohonan']);
    Route::get('/detail-permohonan/{id}', [AdminController::class, 'detailPermohonan']);
    Route::post('/proses-permohonan/{id}', [AdminController::class, 'prosesPermohonan']);

    Route::get('/jadwal', [AdminController::class, 'jadwal']);

    Route::get('/users', [AdminController::class, 'users']);
    Route::post('/users/store', [AdminController::class, 'storeUser']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::put('/users/{id}/role', [AdminController::class, 'changeRole']);
    Route::put('/users/{id}/toggle-status', [AdminController::class, 'toggleStatus']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);

    Route::get('/laporan', [AdminController::class, 'laporan']);
    Route::get('/settings', [AdminController::class, 'settings']);

    Route::get('/notifikasi', [AdminController::class, 'notifikasi']);
    Route::post('/notifikasi/read-all', [AdminController::class, 'readAll']);

    Route::get('/roles', fn() => view('admin.roles'));
});

Route::prefix('user')->middleware(['auth', 'role:mahasiswa,dosen,staf,organisasi'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('/riwayat', [UserController::class, 'riwayat']);
    Route::get('/riwayat-detail/{id}', [UserController::class, 'riwayatDetail']);
    Route::get('/profil', [UserController::class, 'profil']);
    Route::post('/profil', [UserController::class, 'updateProfil']);
    Route::get('/notifikasi', [UserController::class, 'notifikasi']);

    Route::get('/ajukan', [BookingController::class, 'ajukan']);
    Route::get('/ajukan-detail', [BookingController::class, 'ajukanDetail']);
    Route::post('/ajukan-konfirmasi', [BookingController::class, 'ajukanKonfirmasi']);
    Route::post('/ajukan-proses', [BookingController::class, 'ajukanProses']);
});
