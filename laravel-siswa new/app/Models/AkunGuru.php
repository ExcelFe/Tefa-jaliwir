<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AkunGuru extends Authenticatable
{
    use Notifiable;

    protected $table = "tb_akun_guru";
    public $timestamps = false;

    protected $fillable = [
        "kode_guru",
        "email",
        "password",
    ];

    protected $hidden = [
        "password",
    ];

    // Relasi ke data guru (tb_guru) lewat kode_guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, "kode_guru", "kode_guru");
    }

    // Accessor nama guru (fallback ke email kalau data guru belum ada)
    public function getNamaAttribute()
    {
        if ($this->guru?->nama) {
            return trim($this->guru->nama);
        }

        $nameFromEmail = explode("@", $this->email)[0];
        $cleanName = preg_replace('/\d+$/', '', $nameFromEmail);

        return ucwords($cleanName);
    }
}