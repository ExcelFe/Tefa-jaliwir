<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Dashboard siswa (3 halaman): Jadwal, Status Guru, Denah Sekolah.
 *
 * Jadwal : tb_mapel_murid (kelas otomatis dari akun murid yang login) + tb_guru
 * Status : tb_absen_guru + tb_guru
 */
class SiswaController extends Controller
{
    private const HARI = [
        'senin'  => 'Senin',
        'selasa' => 'Selasa',
        'rabu'   => 'Rabu',
        'kamis'  => 'Kamis',
        'jumat'  => 'Jumat',
    ];

    /** GET /siswa/jadwal?hari=senin */
    public function jadwal(Request $request)
    {
        $now = Carbon::now('Asia/Makassar');

        // Hari ini (null kalau Sabtu / Minggu)
        $hariIni = array_keys(self::HARI)[$now->dayOfWeekIso - 1] ?? null;

        // Hari yang dipilih lewat tab; kosong/salah -> hari ini; akhir pekan -> Senin
        $hari = $request->query('hari');
        if (!is_string($hari) || !array_key_exists($hari, self::HARI)) {
            $hari = $hariIni ?? 'senin';
        }

        $kelas = $this->kelasMurid();
        $jadwal = $kelas ? $this->ambilJadwal($kelas, $hari, $hari === $hariIni ? $now : null) : [];

        return view('siswa.jadwal', [
            'kelas'     => $kelas,
            'hariList'  => self::HARI,
            'hari'      => $hari,
            'hariIni'   => $hariIni,
            'akhirPekan' => $hariIni === null,
            'jadwal'    => $jadwal,
        ]);
    }

    /** GET /siswa/status?tanggal=YYYY-MM-DD */
    public function status(Request $request)
    {
        $tanggal = $request->query('tanggal');

        // Format salah / tanggal tidak ada / kosong -> hari ini (WITA)
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
                    'nama'        => trim($item->nama) ?: 'Guru',
                    'mapel'       => !empty($item->mapel) ? trim($item->mapel) : '-',
                    'status'      => $hadir ? 'hadir' : 'tidak',
                    'statusLabel' => $hadir ? 'Hadir' : 'Tidak Hadir',
                ];
            });

        return view('siswa.status', [
            'guru'         => $guru,
            'tanggal'      => $tanggal,
            'tanggalLabel' => Carbon::parse($tanggal, 'Asia/Makassar')->locale('id')->translatedFormat('l, j F Y'),
        ]);
    }

    /** GET /siswa/denah  (isi menyusul) */
    public function denah()
    {
        return view('siswa.denah');
    }

    /* ------------------------------------------------------------------ */

    /**
     * Jadwal satu kelas pada satu hari.
     * $now diisi hanya kalau hari yang dilihat = hari ini (supaya status "Sedang Berlangsung"
     * tidak muncul di hari lain).
     */
    private function ambilJadwal(string $kelas, string $hari, ?Carbon $now): array
    {
        $query = DB::table('tb_mapel_murid')
            ->leftJoin('tb_guru', 'tb_mapel_murid.kode_guru', '=', 'tb_guru.kode_guru')
            ->where('tb_mapel_murid.hari', $hari)
            ->select('tb_mapel_murid.*', 'tb_guru.nama as nama_guru')
            ->orderBy('tb_mapel_murid.jam_sekolah');

        if (preg_match('/\d$/', $kelas)) {
            // 'XI PPLG 1' -> cocok persis
            $query->where('tb_mapel_murid.kelas', $kelas);
        } else {
            // Data murid kadang tanpa nomor ('XI TJKT'), jadwal memakai 'XI TJKT 1'
            $like = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $kelas);
            $query->where('tb_mapel_murid.kelas', 'like', $like . ' %');
        }

        $rows = $query->get();

        // Gabungkan jam berurutan dengan mapel & guru yang sama jadi 1 kartu
        $grup = [];
        foreach ($rows as $r) {
            $i = count($grup) - 1;
            if (
                $i >= 0
                && $grup[$i]['kode_guru'] === $r->kode_guru
                && $grup[$i]['mapel'] === $r->nama_mapel
                && (int) $r->jam_sekolah === $grup[$i]['jam_akhir'] + 1
            ) {
                $grup[$i]['jam_akhir'] = (int) $r->jam_sekolah;
                $grup[$i]['selesai']   = $r->jam_selesai;
                continue;
            }
            $grup[] = [
                'kode_guru' => $r->kode_guru,
                'mapel'     => $r->nama_mapel,
                'guru'      => $r->nama_guru,
                'jam_awal'  => (int) $r->jam_sekolah,
                'jam_akhir' => (int) $r->jam_sekolah,
                'mulai'     => $r->jam_mulai,
                'selesai'   => $r->jam_selesai,
            ];
        }

        $menitSekarang = $now ? $now->hour * 60 + $now->minute : null;

        $jadwal = [];
        foreach ($grup as $g) {
            $mulai   = $this->menit($g['mulai']);
            $selesai = $this->menit($g['selesai']);

            if ($menitSekarang === null) {
                $status = 'Terjadwal';                      // bukan hari ini
            } elseif ($mulai !== null && $selesai !== null && $menitSekarang >= $mulai && $menitSekarang < $selesai) {
                $status = 'Sedang Berlangsung';
            } elseif ($selesai !== null && $menitSekarang >= $selesai) {
                $status = 'Selesai';
            } else {
                $status = 'Akan Datang';
            }

            $jadwal[] = [
                'mapel'    => $g['mapel'],
                'pengajar' => $g['guru'] ? trim($g['guru']) : 'Guru Pengajar',
                'waktu'    => $this->formatJam($g['mulai']) . ' - ' . $this->formatJam($g['selesai']),
                'status'   => $status,
            ];
        }

        return $jadwal;
    }

    /** Kelas murid yang login (X / XI / XII dideteksi otomatis, tingkat tertinggi dulu). */
    private function kelasMurid(): ?string
    {
        $akun = Auth::guard('murid')->user();
        if (!$akun) {
            return null;
        }

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

    /** '07.05' -> '07:05' (desain memakai titik dua) */
    private function formatJam(?string $jam): string
    {
        return $jam === null ? '' : str_replace('.', ':', trim($jam));
    }

    private function tanggalValid(string $tanggal): bool
    {
        [$y, $m, $d] = array_map('intval', explode('-', $tanggal));
        return checkdate($m, $d, $y);
    }
}