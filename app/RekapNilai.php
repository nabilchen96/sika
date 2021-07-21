<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RekapNilai extends Model
{
    protected $primaryKey   = 'id_rekap_nilai';
    protected $fillable     = [
        'id_mahasiswa', 'id_semester', 'nilai_samapta', 'nilai_softskill', 'nilai_pelanggaran', 'nilai_penghargaan'
    ];
}
