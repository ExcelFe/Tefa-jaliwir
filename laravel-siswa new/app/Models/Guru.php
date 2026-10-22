<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = "tb_guru";
    protected $primaryKey = "kode_guru";
    public $timestamps = false;
}