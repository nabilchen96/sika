<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanSakit extends Model
{
    protected $primaryKey   = 'id_catatan_sakit';
    protected $fillable     = [
        'tgl_sakit', 'keterangan_sakit', 'surat_sakit', 'id_mahasiswa'
    ];
}
