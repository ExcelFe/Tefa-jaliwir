<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\GuruDashboardController;
use App\Http\Controllers\PiketAbsenController;

// Halaman umum
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/program', function () {
    return view('program');
})->name('program');

Route::get('/profil', function () {
    return view('profil-guru');
})->name('profil');

// Halaman login: cukup satu route
Route::get('/login', function () {
    return view('login');
})->name('login');

// Proses login dan logout
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// ==========================================
// ROUTE ADMIN
// ==========================================
Route::get('/admin/dashboard', function () {
    if (!session('sudah_login') || session('jenis_akun') !== 'admin') {
        return redirect()->route('login');
    }
    return view('admin.admin-status');
})->name('admin.dashboard');

Route::get('/admin/edit', function () {
    return view('admin.admin-edit');
})->name('admin.edit');

Route::get('/admin/piket', function () {
    return view('admin.admin-piket');
})->name('admin.piket');

Route::get('/admin/rekap-guru', function () {
    return view('admin.admin-rekap-guru');
})->name('admin.rekap.guru');

Route::get('/admin/rekap-siswa', function () {
    return view('admin.admin-rekap-siswa');
})->name('admin.rekap.siswa');

Route::get('/admin/status', function () {
    return view('admin.admin-status');
})->name('admin.status');


// ==========================================
// ROUTE GURU
// ==========================================
Route::get('/guru/dashboard', [
    GuruDashboardController::class,
    'index'
])->name('guru.dashboard');

Route::get('/guru/absen', function () {
    return view('guru.guru-absen');
})->name('guru.absen');

Route::get('/guru/jadwal', function () {
    return view('guru.guru-jadwal');
})->name('guru.jadwal');

Route::get('/guru/jurnal', function () {
    return view('guru.guru-jurnal');
})->name('guru.jurnal');

Route::get('/guru/rekap', function () {
    return view('guru.guru-rekap');
})->name('guru.rekap');


// ==========================================
// ROUTE GURU PIKET
// ==========================================
Route::get('/piket/dashboard', function () {
    return redirect()->route('piket.status');
})->name('piket.dashboard');

Route::get('/piket/status', function () {
    // Proteksi: hanya guru piket yang boleh akses
    if (!session('sudah_login') || session('jenis_akun') !== 'guru_piket') {
        return redirect()->route('login');
    }

    // Tentukan hari ini dalam bahasa Indonesia
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

    $now = now();
    $namaHariEng = $now->format('l');
    $hariIndo    = $daftarHari[$namaHariEng] ?? 'Senin';
    $hariDb      = strtolower($hariIndo);

    // Jika hari libur sabtu/minggu, default ke senin agar jadwal tetap bisa dipratinjau
    if (!in_array($hariDb, ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])) {
        $hariDb = 'senin';
    }

    $tanggalHariIni = $hariIndo . ', ' . $now->format('j')
        . ' ' . ($daftarBulan[(int) $now->format('n')] ?? '')
        . ' ' . $now->format('Y');

    // Ambil data guru
    $guruList = \Illuminate\Support\Facades\DB::table('tb_guru')
        ->select('kode_guru', 'nama', 'mapel')
        ->orderBy('kode_guru')
        ->get();

    // Ambil data absensi hari ini — gunakan DATE format YYYY-MM-DD
    $absenDb = \Illuminate\Support\Facades\DB::table('tb_absen_guru')
        ->where('tanggal', $now->toDateString())
        ->get()
        ->keyBy('kode_guru');

    // Ambil semua jadwal mengajar hari ini
    $jadwalHariIni = \Illuminate\Support\Facades\DB::table('tb_mapel_guru')
        ->where('hari', $hariDb)
        ->orderBy('jam_mulai')
        ->get()
        ->groupBy('kode_guru');

    // Jam saat ini dalam format desimal
    $jamMenitSekarang = (float) $now->format('H.i');

    $dataGuruStatus = $guruList->map(function ($guru) use ($absenDb, $jadwalHariIni, $jamMenitSekarang) {
        $absen = $absenDb[$guru->kode_guru] ?? null;

        // Peta status DB: H = Hadir, T = Tidak Hadir, null = belum dicatat (anggap Hadir)
        $statusAbsen = match ($absen->status ?? null) {
            'H'     => 'Hadir',
            'T'     => 'Tidak Hadir',
            default => 'Hadir',
        };
        $isHadir = !$absen || $absen->status === 'H';

        // Jadwal guru hari ini
        $jadwalGuru = $jadwalHariIni->get($guru->kode_guru, collect());

        // Cari apa yang sedang diajar pada jam sekarang
        $sedangNgajar = null;
        foreach ($jadwalGuru as $j) {
            $mulai   = (float) str_replace(':', '.', $j->jam_mulai);
            $selesai = (float) str_replace(':', '.', $j->jam_selesai);
            if ($jamMenitSekarang >= $mulai && $jamMenitSekarang <= $selesai) {
                $sedangNgajar = $j->nama_mapel . ' di ' . $j->kelas . ' (' . $j->waktu_pelajaran . ')';
                break;
            }
        }

        if (!$sedangNgajar) {
            $sedangNgajar = $jadwalGuru->isNotEmpty()
                ? 'Tidak sedang mengajar (Jadwal: ' . $jadwalGuru->count() . ' jam hari ini)'
                : 'Tidak ada jadwal mengajar hari ini';
        }

        return (object) [
            'kode_guru'     => $guru->kode_guru,
            'nama'          => $guru->nama,
            'mapel_utama'   => $guru->mapel,
            'status_absen'  => $statusAbsen,
            'is_hadir'      => $isHadir,
            'sedang_ngajar' => $sedangNgajar,
            'jadwal_hari_ini' => $jadwalGuru,
        ];
    });

    return view('guru-piket.piket-status', [
        'tanggalHariIni' => $tanggalHariIni,
        'hariDb'         => $hariDb,
        'dataGuruStatus' => $dataGuruStatus,
        'guruList'       => $guruList,
        'absenDb'        => $absenDb,
    ]);
})->name('piket.status');

// Absen Guru — list log + form absensi
Route::get('/piket/absen', [PiketAbsenController::class, 'index'])->name('piket.absen');

// Simpan absensi (POST)
Route::post('/piket/absen/simpan', [PiketAbsenController::class, 'simpan'])->name('piket.absen.simpan');

// Detail absensi per tanggal
Route::get('/piket/absen/detail', [PiketAbsenController::class, 'detail'])->name('piket.absen.detail');


// ==========================================
// ROUTE SISWA
// ==========================================
Route::get('/siswa/dashboard', function () {
    if (!session('sudah_login') || session('jenis_akun') !== 'murid') {
        return redirect()->route('login');
    }
    return view('siswa.siswa-jadwal');
})->name('siswa.dashboard');

Route::get('/siswa/denah', function () {
    return view('siswa.siswa-denah');
})->name('siswa.denah');

Route::get('/siswa/jadwal', function () {
    return view('siswa.siswa-jadwal');
})->name('siswa.jadwal');

Route::get('/siswa/status', function () {
    return view('siswa.siswa-status');
})->name('siswa.status');