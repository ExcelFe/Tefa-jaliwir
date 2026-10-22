<?php

namespace App\Models;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_akun_guru';

    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_guru',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];


}   