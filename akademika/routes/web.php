<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;

/*
|--------------------------------------------------------------------------
BUAT PINDAH PINDAH HALAMAN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');  

Route::get('/program', function () {
    return view('program');
})->name('program');  

Route::get('/profil', function () {
    return view('profil-guru');
})->name('profil');  

Route::get('/login', function () {
    return view('login');
})->name('login');  




// Halaman login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Proses login dan logout
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Dashboard admin
Route::get('/admin/dashboard', function () {
    abort_unless(session('jenis_akun') === 'admin', 403);

    return view('admin.dashboard');
})->name('admin.dashboard');

// Dashboard guru
Route::get('/guru/dashboard', function () {
    abort_unless(session('jenis_akun') === 'guru', 403);

    return view('guru.dashboard');
})->name('guru.dashboard');

// Dashboard murid
Route::get('/siswa/dashboard', function () {
    abort_unless(session('jenis_akun') === 'murid', 403);

    return view('siswa.dashboard');
})->name('siswa.dashboard');




