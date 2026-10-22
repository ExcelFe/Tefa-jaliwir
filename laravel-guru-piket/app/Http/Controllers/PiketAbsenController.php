<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PiketAbsenController extends Controller
{
    /** Helper: cek autentikasi guru piket */
    private function cekAuth()
    {
        return session('sudah_login') && session('jenis_akun') === 'guru_piket';
    }

    /** Helper: format DATE string ke format Indonesia */
    private function formatTanggalIndo(string $dateStr): string
    {
        $daftarHari = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];
        $daftarBulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];
        $dt = Carbon::parse($dateStr);
        return $daftarHari[$dt->format('l')]
            . ', ' . $dt->format('j')
            . ' ' . $daftarBulan[(int) $dt->format('n')]
            . ' ' . $dt->format('Y');
    }

    /** Halaman log absensi guru */
    public function index()
    {
        if (!$this->cekAuth()) {
            return redirect()->route('login');
        }

        $today = now()->toDateString();

        // Tanggal hari ini untuk judul modal
        $tanggalHariIni = $this->formatTanggalIndo($today);

        // Daftar semua guru (untuk modal absensi)
        $guruList = DB::table('tb_guru')
            ->orderBy('kode_guru')
            ->get(['kode_guru', 'nama']);

        // Apakah hari ini sudah ada absensi?
        $sudahAbsen = DB::table('tb_absen_guru')
            ->where('tanggal', $today)
            ->exists();

        // Absensi hari ini untuk pre-fill modal
        $absenHariIni = DB::table('tb_absen_guru')
            ->where('tanggal', $today)
            ->get()
            ->keyBy('kode_guru');

        // Log absensi: tanggal unik yang pernah diabsen (terbaru duluan)
        $logAbsensi = DB::table('tb_absen_guru')
            ->select('tanggal')
            ->distinct()
            ->orderByDesc('tanggal')
            ->get()
            ->map(function ($row) {
                return (object) [
                    'tanggal'           => $row->tanggal,
                    'tanggal_formatted' => $this->formatTanggalIndo($row->tanggal),
                ];
            });

        return view('guru-piket.piket-absen', compact(
            'tanggalHariIni',
            'guruList',
            'sudahAbsen',
            'absenHariIni',
            'logAbsensi'
        ));
    }

    /** Simpan / update absensi guru ke tb_absen_guru */
    public function simpan(Request $request)
    {
        if (!$this->cekAuth()) {
            return redirect()->route('login');
        }

        $kehadiran = $request->input('kehadiran', []);
        $tanggal   = $request->input('tanggal', now()->toDateString());

        foreach ($kehadiran as $kode_guru => $status) {
            // status: 'H' = Hadir, 'T' = Tidak Hadir
            if (!in_array($status, ['H', 'T'])) {
                continue;
            }
            DB::table('tb_absen_guru')->updateOrInsert(
                ['kode_guru' => (int) $kode_guru, 'tanggal' => $tanggal],
                ['status' => $status, 'updated_at' => now()]
            );
        }

        return redirect()->route('piket.status')
            ->with('sukses', 'Absensi guru berhasil disimpan dan status kehadiran telah diperbarui!');
    }

    /** Halaman detail absensi per tanggal */
    public function detail(Request $request)
    {
        if (!$this->cekAuth()) {
            return redirect()->route('login');
        }

        // tanggal dalam format YYYY-MM-DD dari query param
        $tanggal = $request->query('tanggal', now()->toDateString());
        $tanggalFormatted = $this->formatTanggalIndo($tanggal);

        // Semua guru
        $guruAll = DB::table('tb_guru')
            ->orderBy('kode_guru')
            ->get(['kode_guru', 'nama'])
            ->keyBy('kode_guru');

        // Absensi untuk tanggal tersebut
        $absensiDb = DB::table('tb_absen_guru')
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('kode_guru');

        // Gabungkan: semua guru + status (H→Hadir, T→Tidak Hadir, null→Belum dicatat)
        $absensi = $guruAll->map(function ($guru) use ($absensiDb) {
            $record    = $absensiDb[$guru->kode_guru] ?? null;
            $statusRaw = $record ? $record->status : null;
            return (object) [
                'nama'   => $guru->nama,
                'status' => match ($statusRaw) {
                    'H'     => 'Hadir',
                    'T'     => 'Tidak Hadir',
                    default => '-',
                },
            ];
        });

        return view('guru-piket.piket-absen-detail', compact(
            'tanggal',
            'tanggalFormatted',
            'absensi'
        ));
    }
}
