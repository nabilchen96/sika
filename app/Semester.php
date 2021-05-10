<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $primaryKey   = 'id_semester';
    protected $fillable     = [
        'tahun_ajaran', 'nama_semester', 'a_periode_aktif', 'tanggal_mulai',
        'tanggal_selesai', 'is_semester_aktif', 'id_semester_siakad'
    ];
}
