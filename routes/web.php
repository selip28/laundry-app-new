<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\LayananController;

Route::get('/', function () {
    return view('landing');
})->name('home');
// ─── Public ────────────────────────────────────────────────────────────────


// Cek status tanpa login
Route::get('/cek-status',  [TransaksiController::class, 'cekStatus'])->name('cek-status');
Route::post('/cek-status', [TransaksiController::class, 'cekStatus'])->name('cek-status.post');

// ─── Auth ───────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Authenticated ──────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Admin Cabang ───────────────────────────────────────────────────────
    Route::middleware('role:admin_cabang')->group(function () {
        Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi',       [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::patch('/transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
    });

    // ── Admin Cabang + Admin Pusat + SuperAdmin ────────────────────────────
    Route::middleware('role:admin_cabang,admin_pusat,superadmin')->group(function () {
        Route::get('/transaksi',              [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/{transaksi}',  [TransaksiController::class, 'show'])->name('transaksi.show');
        Route::get('/transaksi/{transaksi}/nota', [TransaksiController::class, 'nota'])->name('transaksi.nota');
        Route::get('/laporan',       [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pdf',   [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    });

    // ── Super Admin only ───────────────────────────────────────────────────
    Route::middleware('role:superadmin')->group(function () {
        // Users
        Route::get('/user',           [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create',    [UserController::class, 'create'])->name('user.create');
        Route::post('/user',          [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{user}/edit',   [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{user}',        [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{user}',     [UserController::class, 'destroy'])->name('user.destroy');

        // Cabang
        Route::get('/cabang',              [CabangController::class, 'index'])->name('cabang.index');
        Route::get('/cabang/create',       [CabangController::class, 'create'])->name('cabang.create');
        Route::post('/cabang',             [CabangController::class, 'store'])->name('cabang.store');
        Route::get('/cabang/{cabang}/edit',   [CabangController::class, 'edit'])->name('cabang.edit');
        Route::put('/cabang/{cabang}',        [CabangController::class, 'update'])->name('cabang.update');
        Route::delete('/cabang/{cabang}',     [CabangController::class, 'destroy'])->name('cabang.destroy');

        // Layanan
        Route::get('/layanan',              [LayananController::class, 'index'])->name('layanan.index');
        Route::get('/layanan/create',       [LayananController::class, 'create'])->name('layanan.create');
        Route::post('/layanan',             [LayananController::class, 'store'])->name('layanan.store');
        Route::get('/layanan/{layanan}/edit',   [LayananController::class, 'edit'])->name('layanan.edit');
        Route::put('/layanan/{layanan}',        [LayananController::class, 'update'])->name('layanan.update');
        Route::delete('/layanan/{layanan}',     [LayananController::class, 'destroy'])->name('layanan.destroy');
    });
});