<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Jadwal siswa  : tb_mapel_murid, otomatis sesuai kelas murid yang login + hari ini.
 * Status guru   : tb_absen_guru (join tb_guru).
 */
class DashboardController extends Controller
{
    /**
     * GET /jadwal-siswa
     * Jadwal hari ini untuk murid yang sedang login.
     * Kelas diambil otomatis dari akun (X / XI / XII), hari dari tanggal server (WITA).
     */
    public function getJadwalSiswa(Request $request)
    {
        $now = Carbon::now('Asia/Makassar');

        $hariMap = [1 => 'senin', 2 => 'selasa', 3 => 'rabu', 4 => 'kamis', 5 => 'jumat'];
        $hari = $hariMap[$now->dayOfWeekIso] ?? null;   // Sabtu & Minggu = tidak ada jadwal

        // Khusus mode lokal: /jadwal-siswa?hari=senin untuk mengetes di hari libur
        if (app()->environment('local') && in_array($request->query('hari'), $hariMap, true)) {
            $hari = $request->query('hari');
        }

        $kelas = $this->kelasMurid();

        if (!$hari || !$kelas) {
            return response()->json([]);
        }

        $query = DB::table('tb_mapel_murid')
            ->leftJoin('tb_guru', 'tb_mapel_murid.kode_guru', '=', 'tb_guru.kode_guru')
            ->where('tb_mapel_murid.hari', $hari)
            ->select('tb_mapel_murid.*', 'tb_guru.nama as nama_guru')
            ->orderBy('tb_mapel_murid.jam_sekolah');

        if (preg_match('/\d$/', $kelas)) {
            // contoh 'XI PPLG 1' -> cocok persis
            $query->where('tb_mapel_murid.kelas', $kelas);
        } else {
            // data murid kadang tanpa nomor (contoh 'XI TJKT'), jadwal memakai 'XI TJKT 1'
            $like = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $kelas);
            $query->where('tb_mapel_murid.kelas', 'like', $like . ' %');
        }

        $rows = $query->get();

        // Gabungkan jam pelajaran berurutan dengan mapel & guru yang sama jadi 1 kartu
        $grup = [];
        foreach ($rows as $r) {
            $i = count($grup) - 1;
            if ($i >= 0 && $grup[$i]['kode_guru'] === $r->kode_guru && $grup[$i]['mapel'] === $r->nama_mapel) {
                $grup[$i]['jam_akhir'] = $r->jam_sekolah;
                $grup[$i]['selesai']   = $r->jam_selesai;
                continue;
            }
            $grup[] = [
                'kode_guru' => $r->kode_guru,
                'mapel'     => $r->nama_mapel,
                'guru'      => $r->nama_guru,
                'jam_awal'  => $r->jam_sekolah,
                'jam_akhir' => $r->jam_sekolah,
                'mulai'     => $r->jam_mulai,
                'selesai'   => $r->jam_selesai,
            ];
        }

        $menitSekarang = $now->hour * 60 + $now->minute;
        $aktifSet = false;

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
                'waktu'    => trim(($g['mulai'] ?? '') . ' - ' . ($g['selesai'] ?? ''), ' -'),
                'jam_ke'   => $g['jam_awal'] === $g['jam_akhir'] ? (string) $g['jam_awal'] : $g['jam_awal'] . ' - ' . $g['jam_akhir'],
                'mapel'    => $g['mapel'],
                'status'   => $status,
                'pengajar' => $g['guru'] ?: 'Guru Pengajar',
                'foto'     => '',      // foto pengajar sengaja dikosongkan
                'aktif'    => 0,
            ];
        }

        // Kartu yang tampil pertama: yang sedang berlangsung, kalau tidak ada = yang berikutnya
        foreach (['Sedang Berlangsung', 'Akan Datang'] as $cari) {
            foreach ($jadwal as $k => $j) {
                if ($j['status'] === $cari) { $jadwal[$k]['aktif'] = 1; $aktifSet = true; break; }
            }
            if ($aktifSet) break;
        }

        return response()->json($jadwal);
    }

    /** Kelas murid yang login (X / XI / XII dideteksi otomatis dari akunnya). */
    private function kelasMurid(): ?string
    {
        $akun = Auth::guard('murid')->user();
        if (!$akun) {
            return null;
        }

        // Tingkat tertinggi dulu, sama seperti accessor nama di AkunMurid
        $kandidat = [
            [$akun->nis_xii, fn () => $akun->siswaXII],
            [$akun->nis_xi,  fn () => $akun->siswaXI],
            [$akun->nis_x,   fn () => $akun->siswaX],
        ];

        foreach ($kandidat as [$nis, $ambil]) {
            if ($nis && ($siswa = $ambil()) && !empty($siswa->kelas)) {
                return trim($siswa->kelas);
            }
        }

        return null;
    }

    /** '07.05' / '07:05' -> menit sejak 00:00 (null kalau format tidak dikenali) */
    private function menit(?string $jam): ?int
    {
        if ($jam !== null && preg_match('/^(\d{1,2})[.:](\d{2})$/', trim($jam), $m)) {
            return (int) $m[1] * 60 + (int) $m[2];
        }
        return null;
    }

    /**
     * GET /status-guru?tanggal=YYYY-MM-DD
     * Mengembalikan guru yang punya data absen pada tanggal tsb.
     * Status hanya 2: Hadir (H) dan Tidak Hadir (selain H).
     */
    public function getStatusGuru(Request $request)
    {
        $tanggal = $request->query('tanggal');

        // Validasi format tanggal; kalau kosong/salah, pakai hari ini (WITA)
        if (!is_string($tanggal) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal) || !$this->tanggalValid($tanggal)) {
            $tanggal = Carbon::now('Asia/Makassar')->format('Y-m-d');
        }

        $guru = DB::table('tb_absen_guru')
            ->join('tb_guru', 'tb_absen_guru.kode_guru', '=', 'tb_guru.kode_guru')
            ->whereDate('tb_absen_guru.tanggal', $tanggal)
            ->select(
                'tb_absen_guru.id',
                'tb_guru.kode_guru',
                'tb_guru.nama',
                'tb_guru.mapel',
                'tb_absen_guru.status as status_db'
            )
            ->orderByDesc('tb_absen_guru.id')   // data absen terbaru dulu
            ->get()
            ->unique('kode_guru')               // 1 guru = 1 baris (ambil yang terbaru)
            ->sortBy('nama', SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->map(function ($item) {
                $hadir = $item->status_db === 'H';

                return [
                    'nama'        => $item->nama ?: 'Guru',
                    'mapel'       => !empty($item->mapel) ? $item->mapel : '-',
                    'status'      => $hadir ? 'hadir' : 'tidak',
                    'statusClass' => $hadir ? 'ok' : 'bad',
                    'statusLabel' => $hadir ? 'Hadir' : 'Tidak Hadir',
                ];
            });

        return response()->json($guru);
    }

    private function tanggalValid(string $tanggal): bool
    {
        [$y, $m, $d] = array_map('intval', explode('-', $tanggal));
        return checkdate($m, $d, $y);
    }
}