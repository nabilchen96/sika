<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    protected $primaryKey   = 'id_catatan_perizinan';
    protected $fillable     = [
        'id_mahasiswa', 'tgl_izin_keluar', 'tgl_izin_kembali', 'id_semester', 'keterangan_izin'
    ];
}
