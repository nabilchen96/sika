<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BatasPelanggaran extends Model
{
    protected $primaryKey   = 'id_batas_pelanggaran';
    protected $fillable     = [
        'periode', 'batas_kritis', 'batas_maksimal', 'tingkat'
    ];
}
