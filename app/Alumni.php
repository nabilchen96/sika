<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $primaryKey   = 'id_alumni';
    protected $fillable     = [
        'id_mahasiswa',''
    ];
}
