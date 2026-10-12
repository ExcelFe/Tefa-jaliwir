\<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    private function hariSekarang()
    {
        $hari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        return $hari[Carbon::now()->dayOfWeekIso];
    }

    private function cariJadwal($jadwalList)
    {
        $jamSekarang = Carbon::now()->format('H:i');

        foreach ($jadwalList as $jadwal) {

            // Contoh:
            // "08:00 - 08:30"

            [$mulai, $selesai] = explode(' - ', $jadwal->jam);

            if (
                $jamSekarang >= $mulai &&
                $jamSekarang < $selesai
            ) {
                return $jadwal;
            }
        }

        return null;
    }

    public function siswaSekarang()
    {
        $user = Auth::user();

        $siswa = $user->siswa;

        $hari = $this->hariSekarang();

        $jadwal = Jadwal::where('hari', $hari)
            ->where('kelas', $siswa->kelas)
            ->get();

        $jadwalSekarang = $this->cariJadwal($jadwal);

        return response()->json($jadwalSekarang);
    }

    public function guruSekarang()
    {
        $user = Auth::user();

        $guru = $user->guru;

        $hari = $this->hariSekarang();

        $jadwal = Jadwal::where('hari', $hari)
            ->where('guru_id', $guru->id_guru)
            ->get();

        $jadwalSekarang = $this->cariJadwal($jadwal);

        return response()->json($jadwalSekarang);
    }
}