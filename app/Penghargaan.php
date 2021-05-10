<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penghargaan extends Model
{
    protected $primaryKey   = 'id_penghargaan';
    protected $fillable     = [
        'penghargaan', 'bidang_penghargaan', 'poin_penghargaan'
    ];
}
