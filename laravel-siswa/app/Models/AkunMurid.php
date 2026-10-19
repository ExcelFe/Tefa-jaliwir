<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AkunMurid extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_akun_murid';
    public $timestamps = false;

    protected $fillable = [
        'nis_x',
        'nis_xi',
        'nis_xii',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi ke Siswa Kelas X
    public function siswaX()
    {
        return $this->belongsTo(SiswaX::class, 'nis_x', 'nis_x');
    }

    // Relasi ke Siswa Kelas XI
    public function siswaXI()
    {
        return $this->belongsTo(SiswaXI::class, 'nis_xi', 'nis_xi');
    }

    // Relasi ke Siswa Kelas XII
    public function siswaXII()
    {
        return $this->belongsTo(SiswaXII::class, 'nis_xii', 'nis_xii');
    }

    // Accessor Nama Murid (Mencakup X, XI, XII, & Fallback Email)
    public function getNamaAttribute()
    {
        // 1. Cek jika terdaftar di kelas XII
        if ($this->nis_xii && class_exists(SiswaXII::class) && $this->siswaXII?->nama) {
            return $this->siswaXII->nama;
        }

        // 2. Cek jika terdaftar di kelas XI
        if ($this->nis_xi && class_exists(SiswaXI::class) && $this->siswaXI?->nama) {
            return $this->siswaXI->nama;
        }

        // 3. Cek jika terdaftar di kelas X
        if ($this->nis_x && class_exists(SiswaX::class) && $this->siswaX?->nama) {
            return $this->siswaX->nama;
        }

        // 4. Fallback jika data siswa belum ada di DB: bersihkan angka dari email (contoh: 'kusuma1636' -> 'Kusuma')
        $nameFromEmail = explode('@', $this->email)[0];
        $cleanName = preg_replace('/\d+$/', '', $nameFromEmail);

        return ucwords($cleanName);
    }
}