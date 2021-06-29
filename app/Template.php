<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $primaryKey   = 'id_template';
    protected $fillable     = [
        'template', 'judul_template', 'keterangan', 'kategori'
    ];
}
