<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $primaryKey   = 'id_kamar';
    protected $fillable     = [
        'nama_kamar', 'nama_asrama', 'batas_kamar'
    ];
}
