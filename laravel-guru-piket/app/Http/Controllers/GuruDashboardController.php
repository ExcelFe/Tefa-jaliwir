<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Pastikan pengguna sudah login sebagai guru
        if (
            !$request->session()->get('sudah_login') ||
            $request->session()->get('jenis_akun') !== 'guru'
        ) {
            return redirect()->route('login');
        }

        // Ambil email akun dari session
        $email = $request->session()->get('email_akun');

        // Cari akun guru
        $akun = DB::table('tb_akun_guru')
            ->where('email', $email)
            ->first();

        if (!$akun) {
            abort(404, 'Akun guru tidak ditemukan.');
        }

        // Cari profil berdasarkan kode_guru
        $guru = DB::table('tb_guru')
            ->where('kode_guru', $akun->kode_guru)
            ->first();

        if (!$guru) {
            abort(404, 'Data guru tidak ditemukan.');
        }

        return view('guru.guru-jadwal', compact('guru'));
    }
}
