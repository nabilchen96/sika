<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AturanNilaiSamapta extends Model
{
    protected $primaryKey   = 'id_nilai_samapta';
    protected $fillable     = [
        'untuk', 'jenis_samapta', 'jumlah', 'nilai', 'ukuran_menit'
    ];
}
