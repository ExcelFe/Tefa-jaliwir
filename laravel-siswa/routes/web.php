<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/beranda', function () {
    return view('beranda');
});

Route::get('/profil-manajemen', function () {
    return view('profil-manajemen');
});

Route::get('/program-sekolah', function () {
    return view('program-sekolah');
});

Route::get('/siswa/dashboard', function () {
    return view('dashboard.siswa');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest:murid')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth:murid')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.siswa'); // <-- Ubah 'dashboard' menjadi 'dashboard.siswa'
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth:murid'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.siswa');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // API Dashboard
    Route::get('/jadwal-siswa', [DashboardController::class, 'getJadwalSiswa'])->name('api.jadwal.siswa');
    Route::get('/status-guru', [DashboardController::class, 'getStatusGuru'])->name('api.guru.status');
});