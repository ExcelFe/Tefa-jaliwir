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

                $sessionData = [
                    'sudah_login' => true,
                    'jenis_akun'  => $jenis,
                    'email_akun'  => $akun->email,
                ];

                // Cek apakah guru ini adalah guru piket
                if ($jenis === 'guru') {
                    $isGuruPiket = DB::table('tb_guru_piket')
                        ->where('kode_guru', $akun->kode_guru)
                        ->exists();

                    if ($isGuruPiket) {
                        $namaGuru = DB::table('tb_guru')
                            ->where('kode_guru', $akun->kode_guru)
                            ->value('nama');

                        $sessionData['jenis_akun'] = 'guru_piket';
                        $sessionData['kode_guru']  = $akun->kode_guru;
                        $sessionData['nama_guru']  = $namaGuru ?? $akun->email;
                    }
                }

                $request->session()->put($sessionData);

                // Arahkan ke dashboard sesuai jenis akun
                return match ($sessionData['jenis_akun']) {
                    'admin'      => redirect()->route('admin.dashboard'),
                    'guru_piket' => redirect()->route('piket.status'),
                    'guru'       => redirect()->route('guru.dashboard'),
                    'murid'      => redirect()->route('siswa.dashboard'),
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
