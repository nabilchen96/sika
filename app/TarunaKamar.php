<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TarunaKamar extends Model
{
    protected $primaryKey   = 'id_taruna_kamar';
    protected $fillable     = [
        'id_mahasiswa', 'id_kamar'
    ];
}
