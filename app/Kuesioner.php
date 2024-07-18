<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    protected $primaryKey   = 'id_kuesioner';
    protected $fillable     = [
        'judul_kuesioner', 'status'
    ];
}
