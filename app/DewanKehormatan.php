<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DewanKehormatan extends Model
{

    protected $fillable     = [
        'id', 'nama_pejabat', 'jabatan', 'jabatan_kepanitiaan'
    ];
}
