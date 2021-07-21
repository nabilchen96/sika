<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AturanNilaibbi extends Model
{
    protected $primaryKey   = 'id_nilai_bbi';
    protected $fillable     = [
        'untuk', 'stakes', 'nilai', 'bmi'
    ];
}
