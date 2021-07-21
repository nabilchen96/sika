<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenilaianSamapta extends Model
{
    protected $primaryKey   = 'id_nilai_samapta';
    protected $fillable     = [
        'id_mahasiswa',
        'id_semester',
        'jarak_lari',
        'nilai_lari',
        'jumlah_push_up',
        'nilai_push_up',
        'jumlah_sit_up',
        'nilai_sit_up',
        'jumlah_shuttle_run',
        'nilai_shuttle_run',
        'tinggi_badan',
        'berat_badan',
        'nilai_samapta',
        'stakes',
        'nilai_bbi'
    ];
}
