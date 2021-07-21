<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenilaianSoftSkill extends Model
{
    protected $primaryKey   = 'id_nilai_softskill';
    protected $fillable     = [
        'id_mahasiswa', 'id_semester', 'id_komponen_softskill', 'nilai'
    ];
}
