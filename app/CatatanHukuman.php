<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanHukuman extends Model
{
    protected $primaryKey   = 'id_catatan_hukuman';
    protected $fillable     = [
        'id_mahasiswa', 'is_dikerjakan', 'id_semester', 'keterangan', 'rubah_hukuman'
    ];
}
