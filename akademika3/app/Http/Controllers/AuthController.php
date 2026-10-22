<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Periksa tabel akun admin, guru, dan murid
        $daftarAkun = [
            'admin' => 'tb_akun_admin',
            'guru'  => 'tb_akun_guru',
            'murid' => 'tb_akun_murid',
        ];

        foreach ($daftarAkun as $jenis => $tabel) {
            $akun = DB::table($tabel)
                ->where('email', $request->email)
                ->first();

            // Jika email ditemukan dan password cocok
            if ($akun && Hash::check(
                $request->password,
                $akun->password
            )) {
                // Buat session login
                $request->session()->regenerate();

                $request->session()->put([
                    'sudah_login' => true,
                    'jenis_akun' => $jenis,
                    'email_akun' => $akun->email,
                ]);

                // Arahkan ke dashboard sesuai jenis akun
                return match ($jenis) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'guru'  => redirect()->route('guru.dashboard'),
                    'murid' => redirect()->route('siswa.dashboard'),
                };
            }
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
