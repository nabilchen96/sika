<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanPenghargaan extends Model
{
    protected $primaryKey   = 'id_catatan_penghargaan';
    protected $fillable     = [ 
        'id_penghargaan', 'id_mahasiswa', 'id_semester', 'sk_penghargaan', 'tgl_penghargaan', 
        'template_penghargaan', 'keterangan'
    ];
}
