<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asuhan extends Model
{
    protected $primaryKey   = 'id_asuhan';
    protected $fillable     = [
        'id_mahasiswa', 'id_pengasuh'
    ];
}
