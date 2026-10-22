<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Dashboard guru.
 *
 * Sudah aktif:
 *   - jadwal hari ini per guru (tb_mapel_guru, sesuai guru yang login + hari ini)
 * Belum (menyusul):
 *   - absen siswa
 *   - jurnal kelas
 *   - rekap absensi
 */
class GuruDashboardController extends Controller
{
    public function index()
    {
        return view("dashboard.guru");
    }

    /**
     * GET /jadwal-guru
     * Jadwal mengajar hari ini untuk guru yang sedang login.
     * Guru diambil dari akun (kode_guru), hari dari tanggal server (WITA).
     */
    public function getJadwalGuru(Request $request)
    {
        $now = Carbon::now('Asia/Makassar');

        $hariMap = [1 => 'senin', 2 => 'selasa', 3 => 'rabu', 4 => 'kamis', 5 => 'jumat'];
        $hari = $hariMap[$now->dayOfWeekIso] ?? null;   // Sabtu & Minggu = tidak ada jadwal

        // Khusus mode lokal: /jadwal-guru?hari=senin untuk mengetes di hari libur
        if (app()->environment('local') && in_array($request->query('hari'), $hariMap, true)) {
            $hari = $request->query('hari');
        }

        $akun = Auth::guard('guru')->user();
        $kodeGuru = $akun ? $akun->kode_guru : null;

        if (!$hari || !$kodeGuru) {
            return response()->json([]);
        }

        // Hanya baris milik guru ini (baris kosong kode_guru NULL otomatis tidak ikut)
        $rows = DB::table('tb_mapel_guru')
            ->where('kode_guru', $kodeGuru)
            ->where('hari', $hari)
            ->select('id', 'nama_mapel', 'jam_sekolah', 'kelas', 'jam_mulai', 'jam_selesai')
            ->get()
            // Urut berdasarkan waktu mulai (bukan jam_sekolah), karena kelas X (siang)
            // dan kelas XI/XII (pagi) sama-sama memakai nomor jam 1-10.
            ->sortBy(function ($r) {
                return [$this->menit($r->jam_mulai) ?? 9999, (int) $r->jam_sekolah];
            })
            ->values();

        // Gabungkan jam berurutan dengan kelas & mapel yang sama jadi 1 kartu
        $grup = [];
        foreach ($rows as $r) {
            $i = count($grup) - 1;
            if (
                $i >= 0
                && trim($grup[$i]['kelas']) === trim((string) $r->kelas)
                && trim((string) $grup[$i]['mapel']) === trim((string) $r->nama_mapel)
                && (int) $r->jam_sekolah === (int) $grup[$i]['jam_akhir'] + 1
            ) {
                $grup[$i]['jam_akhir'] = (int) $r->jam_sekolah;
                $grup[$i]['selesai']   = $r->jam_selesai;
                continue;
            }
            $grup[] = [
                'kelas'     => trim((string) $r->kelas),
                'mapel'     => $r->nama_mapel,
                'jam_awal'  => (int) $r->jam_sekolah,
                'jam_akhir' => (int) $r->jam_sekolah,
                'mulai'     => $r->jam_mulai,
                'selesai'   => $r->jam_selesai,
            ];
        }

        $menitSekarang = $now->hour * 60 + $now->minute;

        $jadwal = [];
        foreach ($grup as $g) {
            $mulai   = $this->menit($g['mulai']);
            $selesai = $this->menit($g['selesai']);

            if ($mulai !== null && $selesai !== null && $menitSekarang >= $mulai && $menitSekarang < $selesai) {
                $status = 'Sedang Berlangsung';
            } elseif ($selesai !== null && $menitSekarang >= $selesai) {
                $status = 'Selesai';
            } else {
                $status = 'Akan Datang';
            }

            $jadwal[] = [
                'waktu'  => trim(($g['mulai'] ?? '') . ' - ' . ($g['selesai'] ?? ''), ' -'),
                'jam_ke' => $g['jam_awal'] === $g['jam_akhir']
                    ? (string) $g['jam_awal']
                    : $g['jam_awal'] . ' - ' . $g['jam_akhir'],
                'kelas'  => $g['kelas'],
                'mapel'  => $g['mapel'],
                'status' => $status,
                'aktif'  => 0,
            ];
        }

        // Kartu yang tampil pertama: yang sedang berlangsung, kalau tidak ada = yang berikutnya
        foreach (['Sedang Berlangsung', 'Akan Datang'] as $cari) {
            $ketemu = false;
            foreach ($jadwal as $k => $j) {
                if ($j['status'] === $cari) {
                    $jadwal[$k]['aktif'] = 1;
                    $ketemu = true;
                    break;
                }
            }
            if ($ketemu) break;
        }

        return response()->json($jadwal);
    }

    /** '07.05' / '07:05' -> menit sejak 00:00 (null kalau format tidak dikenali) */
    private function menit(?string $jam): ?int
    {
        if ($jam !== null && preg_match('/^(\d{1,2})[.:](\d{2})$/', trim($jam), $m)) {
            return (int) $m[1] * 60 + (int) $m[2];
        }
        return null;
    }
}