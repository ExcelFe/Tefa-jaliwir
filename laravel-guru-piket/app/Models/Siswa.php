<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'tb_siswa';

    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'nama',
        'kelas',
        'jurusan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

