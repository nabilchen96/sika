<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hukuman extends Model
{
    protected $primaryKey   = 'id_hukuman';
    protected $fillable     = [
        'hukuman', 'kategori_hukuman'
    ];
}
