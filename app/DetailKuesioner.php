<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailKuesioner extends Model
{
    protected $primaryKey   = 'id_detail_kuesioner';
    protected $fillable     = [
        'id_kuesioner', 'soal', 'jenis_soal', 'jawaban'
    ];
}
