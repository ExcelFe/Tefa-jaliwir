<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;

// Halaman publik (hapus yang view-nya belum ada)
Route::get('/beranda', fn () => view('beranda'));
Route::get('/profil-manajemen', fn () => view('profil-manajemen'));
Route::get('/program-sekolah', fn () => view('program-sekolah'));

Route::get('/', fn () => redirect()->route('login'));

// Belum login
Route::middleware('guest:murid')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Sudah login sebagai murid
Route::middleware('auth:murid')->group(function () {
    // Tujuan setelah login (juga dipakai middleware guest) -> halaman Jadwal
    Route::get('/dashboard', fn () => redirect()->route('siswa.jadwal'))->name('dashboard');

    Route::get('/siswa/jadwal', [SiswaController::class, 'jadwal'])->name('siswa.jadwal');
    Route::get('/siswa/status', [SiswaController::class, 'status'])->name('siswa.status');
    Route::get('/siswa/denah',  [SiswaController::class, 'denah'])->name('siswa.denah');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});