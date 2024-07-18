<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanPelanggaran extends Model
{
    protected $primaryKey   = 'id_catatan_pelanggaran';
    protected $fillable     = ['id_mahasiswa', 
        'id_pelanggaran', 'id_pencatat', 'bukti_pelanggaran', 'id_semester', 'poin_pelanggaran'
    ];
}
