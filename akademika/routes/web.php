<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login');
})->name('admin');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


/*
|--------------------------------------------------------------------------
| DASHBOARD SISWA
|--------------------------------------------------------------------------
*/

Route::get('/siswa/dashboard', function () {
    return view('siswa.dashboard');
})->middleware('auth')
  ->name('siswa.dashboard');


/*
|--------------------------------------------------------------------------
| DASHBOARD GURU
|--------------------------------------------------------------------------
*/

Route::get('/guru/dashboard', function () {
    return view('guru.dashboard');
})->middleware('auth')
  ->name('guru.dashboard');


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


    Route::middleware('auth')->group(function () {

    Route::get('/api/siswa/jadwal-sekarang', [
        JadwalController::class,
        'siswaSekarang'
    ]);

    Route::get('/api/guru/jadwal-sekarang', [
        JadwalController::class,
        'guruSekarang'
    ]);

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

