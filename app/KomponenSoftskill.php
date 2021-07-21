<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomponenSoftskill extends Model
{
    protected $primaryKey   = 'id_komponen_softskill';
    protected $fillable     = [
        'jenis_softskill', 'keterangan_softskill'
    ];
}
