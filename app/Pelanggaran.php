<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $primaryKey   = 'id_pelanggaran';
    protected $fillable     = [
        'pelanggaran', 'kategori_pelanggaran', 'poin_pelanggaran'
    ];
}
