<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'tb_guru';

    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'jenis_kelamin',
        'nomer_tlp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}