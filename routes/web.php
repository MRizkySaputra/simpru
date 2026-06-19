<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

Route::redirect('/', '/login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-process', [AuthController::class, 'loginProcess'])
    ->middleware('throttle:5,1');

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register-process', [AuthController::class, 'registerProcess'])
    ->middleware('throttle:5,1');
Route::get('/register-success', function () {
    return view('auth.register-success');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forget-password', function () {
    return view('auth.forget-password');
});

Route::get('/forget-password-success', function () {
    return view('auth.forget-password-success');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/ruangan', [AdminController::class, 'ruangan']);
    Route::post('/ruangan/store', [AdminController::class, 'storeRuangan']);
    Route::delete('/ruangan/{id}', [AdminController::class, 'deleteRuangan']);
    Route::put('/ruangan/{id}', [AdminController::class, 'updateRuangan']);
    Route::get('/permohonan', [AdminController::class, 'permohonan']);
    Route::get('/jadwal', [AdminController::class, 'jadwal']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/laporan', [AdminController::class, 'laporan']);
    Route::get('/detail-permohonan/{id}', [AdminController::class, 'detailPermohonan']);
    Route::post('/proses-permohonan/{id}', [AdminController::class, 'prosesPermohonan']);
    Route::post('/users/store', [AdminController::class, 'storeUser']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::put('/users/{id}/role', [AdminController::class, 'changeRole']);
    Route::put('/users/{id}/toggle-status', [AdminController::class, 'toggleStatus']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    Route::get('/settings', [AdminController::class, 'settings']);
    Route::get('/notifikasi', [AdminController::class, 'notifikasi']);
    Route::get('/roles', [AdminController::class, 'roles']);
    Route::post('/roles/store', [AdminController::class, 'storeRole']);
    Route::put('/roles/{id}', [AdminController::class, 'updateRole']);
    Route::delete('/roles/{id}', [AdminController::class, 'deleteRole']);
    Route::post('/settings', [AdminController::class, 'updateSettings']);
    Route::post('/settings/clear-cache', [AdminController::class, 'clearCache']);
    Route::post('/settings/backup', [AdminController::class, 'createBackup']);
    Route::post('/settings/maintenance', [AdminController::class, 'toggleMaintenance']);

    Route::post('/settings/reset-data', [AdminController::class, 'resetData']);
    Route::post('/settings/factory-reset', [AdminController::class, 'factoryReset']);
});

Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('/riwayat', [UserController::class, 'riwayat']);
    Route::get('/profil', [UserController::class, 'profil']);
    Route::get('/ajukan', [BookingController::class, 'ajukan']);
    Route::get('/ajukan-detail', [BookingController::class, 'ajukanDetail']);
    Route::post('/ajukan-proses', [BookingController::class, 'ajukanProses']);
    Route::post('/ajukan-konfirmasi', [BookingController::class, 'ajukanKonfirmasi']);
    Route::get('/riwayat-detail/{id}', [UserController::class, 'riwayatDetail']);
    Route::get('/riwayat-detail/{id}/cetak', [UserController::class, 'cetakBukti']);
    Route::get('/notifikasi', [UserController::class, 'notifikasi']);
});
