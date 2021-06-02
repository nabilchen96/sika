<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JawabanKuesioner extends Model
{
    protected $primaryKey   = 'id_jawab_kuesioner';
    protected $fillable     = [
        'id_alumni',
        'id_detail_kuesioner',
        'jawaban'
    ];
}
