<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PiketController extends Controller
{
    /** Bali = WITA. Dipakai agar hari/jam tidak bergantung config app.timezone. */
    private const TZ = 'Asia/Makassar';

    private const HARI = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'];

    private const BULAN = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    /** enum tb_absen_guru.status */
    private const STATUS = ['H' => 'Hadir', 'I' => 'Izin', 'S' => 'Sakit', 'A' => 'Tidak Hadir'];

    /* ------------------------------------------------------------------ */

    /** Hanya akun guru piket yang boleh masuk. */
    private function guard(Request $request)
    {
        if (
            !$request->session()->get('sudah_login') ||
            $request->session()->get('jenis_akun') !== 'guru_piket'
        ) {
            return redirect()->route('login');
        }
        return null;
    }

    private function label(Carbon $d): string
    {
        return self::HARI[$d->dayOfWeekIso] . ', ' . $d->day . ' ' . self::BULAN[$d->month] . ' ' . $d->year;
    }

    /** "07.05" / "07:05" -> menit sejak 00:00 */
    private function menit(?string $jam): int
    {
        $p = preg_split('/[.:]/', trim((string) $jam));
        return ((int) ($p[0] ?? 0)) * 60 + (int) ($p[1] ?? 0);
    }

    /* ------------------------------------------------------------------ */

    public function status(Request $request)
    {
        if ($r = $this->guard($request)) return $r;

        $now      = Carbon::now(self::TZ);
        $isLibur  = $now->isWeekend();
        // Sabtu/Minggu: jadwal Senin dipakai sebagai pratinjau
        $hariDb   = $isLibur ? 'senin' : strtolower(self::HARI[$now->dayOfWeekIso]);
        $menitNow = $now->hour * 60 + $now->minute;

        $guruList = DB::table('tb_guru')
            ->select('kode_guru', 'nama', 'mapel')
            ->orderBy('kode_guru')
            ->get();

        $absenDb = DB::table('tb_absen_guru')
            ->where('tanggal', $now->toDateString())
            ->get()
            ->keyBy('kode_guru');

        $jadwalHariIni = DB::table('tb_mapel_guru')
            ->where('hari', $hariDb)
            ->orderBy('jam_sekolah')
            ->get()
            ->groupBy('kode_guru');

        $dataGuruStatus = $guruList->map(function ($guru) use ($absenDb, $jadwalHariIni, $menitNow, $isLibur) {
            $kode        = $absenDb->get($guru->kode_guru)->status ?? 'H';   // belum diabsen = dianggap hadir
            $statusAbsen = self::STATUS[$kode] ?? 'Hadir';
            $jadwalGuru  = $jadwalHariIni->get($guru->kode_guru, collect());

            $sedang = null;
            if (!$isLibur) {
                foreach ($jadwalGuru as $j) {
                    if ($menitNow >= $this->menit($j->jam_mulai) && $menitNow < $this->menit($j->jam_selesai)) {
                        $sedang = $j->nama_mapel . ' di ' . $j->kelas . ' (' . $j->waktu_pelajaran . ')';
                        break;
                    }
                }
            }
            if (!$sedang) {
                $sedang = $isLibur
                    ? 'Hari libur (tidak ada KBM)'
                    : ($jadwalGuru->isNotEmpty()
                        ? 'Tidak sedang mengajar (Jadwal: ' . $jadwalGuru->count() . ' jam hari ini)'
                        : 'Tidak ada jadwal mengajar hari ini');
            }

            return (object) [
                'kode_guru'       => $guru->kode_guru,
                'nama'            => $guru->nama,
                'mapel_utama'     => $guru->mapel,
                'status_absen'    => $statusAbsen,
                'is_hadir'        => $kode === 'H',
                'sedang_ngajar'   => $sedang,
                'jadwal_hari_ini' => $jadwalGuru,
            ];
        });

        return view('guru-piket.piket-status', [
            'tanggalHariIni' => $this->label($now),
            'hariDb'         => $hariDb,
            'isLibur'        => $isLibur,
            'dataGuruStatus' => $dataGuruStatus,
        ]);
    }

    /* ------------------------------------------------------------------ */

    public function absen(Request $request)
    {
        if ($r = $this->guard($request)) return $r;

        $today = Carbon::now(self::TZ)->toDateString();

        // Riwayat: tanggal yang pernah diabsen (maks 30) + hari ini selalu ada
        $tanggal = DB::table('tb_absen_guru')
            ->select('tanggal')->distinct()
            ->orderByDesc('tanggal')->limit(30)
            ->pluck('tanggal')
            ->map(fn ($t) => substr((string) $t, 0, 10))
            ->all();
        if (!in_array($today, $tanggal, true)) {
            array_unshift($tanggal, $today);
        }
        $riwayat = array_map(fn ($t) => (object) [
            'iso'   => $t,
            'label' => $this->label(Carbon::parse($t, self::TZ)),
        ], $tanggal);

        // Daftar guru untuk pop-up + status hari ini (kalau sudah pernah disimpan)
        $guruList = DB::table('tb_guru')
            ->leftJoin('tb_absen_guru', function ($j) use ($today) {
                $j->on('tb_guru.kode_guru', '=', 'tb_absen_guru.kode_guru')
                  ->where('tb_absen_guru.tanggal', '=', $today);
            })
            ->select('tb_guru.kode_guru', 'tb_guru.nama', 'tb_absen_guru.status')
            ->orderBy('tb_guru.kode_guru')
            ->get();

        return view('guru-piket.piket-absen', [
            'riwayat'      => $riwayat,
            'guruList'     => $guruList,
            'labelHariIni' => $this->label(Carbon::now(self::TZ)),
        ]);
    }

    public function simpanAbsen(Request $request)
    {
        if ($r = $this->guard($request)) return $r;

        $request->validate([
            'kehadiran'   => ['required', 'array'],
            'kehadiran.*' => ['in:hadir,tidak-hadir'],
        ]);

        $now      = Carbon::now(self::TZ);
        $today    = $now->toDateString();
        $validIds = DB::table('tb_guru')->pluck('kode_guru')->map(fn ($k) => (int) $k)->all();

        DB::transaction(function () use ($request, $today, $validIds) {
            foreach ($request->input('kehadiran') as $kode => $nilai) {
                $kode = (int) $kode;
                if (!in_array($kode, $validIds, true)) continue;

                $ada = DB::table('tb_absen_guru')
                    ->where('kode_guru', $kode)->where('tanggal', $today)->first();

                if ($nilai === 'hadir') {
                    $status = 'H';
                } else {
                    // Izin/Sakit yang sudah tercatat tidak ditimpa jadi Alpa
                    $status = ($ada && in_array($ada->status, ['I', 'S', 'A'], true)) ? $ada->status : 'A';
                }

                if ($ada) {
                    DB::table('tb_absen_guru')->where('id', $ada->id)
                        ->update(['status' => $status, 'updated_at' => now()]);
                } else {
                    DB::table('tb_absen_guru')
                        ->insert(['kode_guru' => $kode, 'tanggal' => $today, 'status' => $status]);
                }
            }
        });

        return redirect()->route('piket.absen')
            ->with('sukses', 'Absensi guru ' . $this->label($now) . ' berhasil disimpan.');
    }

    /* ------------------------------------------------------------------ */

    public function detail(Request $request)
    {
        if ($r = $this->guard($request)) return $r;

        $q = (string) $request->query('tanggal', '');
        try {
            $tgl = preg_match('/^\d{4}-\d{2}-\d{2}$/', $q)
                ? Carbon::createFromFormat('!Y-m-d', $q, self::TZ)
                : Carbon::now(self::TZ);
        } catch (\Throwable $e) {
            $tgl = Carbon::now(self::TZ);
        }
        $iso = $tgl->toDateString();

        $absensi = DB::table('tb_guru')
            ->leftJoin('tb_absen_guru', function ($j) use ($iso) {
                $j->on('tb_guru.kode_guru', '=', 'tb_absen_guru.kode_guru')
                  ->where('tb_absen_guru.tanggal', '=', $iso);
            })
            ->select('tb_guru.kode_guru', 'tb_guru.nama', 'tb_absen_guru.status')
            ->orderBy('tb_guru.kode_guru')
            ->get()
            ->map(fn ($g) => (object) [
                'nama'   => $g->nama,
                'status' => $g->status ? (self::STATUS[$g->status] ?? 'Hadir') : 'Belum Diabsen',
            ]);

        return view('guru-piket.piket-absen-detail', [
            'tanggalLabel' => $this->label($tgl),
            'absensi'      => $absensi,
        ]);
    }
}