<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupKordinasiPengasuh extends Model
{
    protected $primaryKey   = 'id_grup_kordinasi_pengasuh';
    protected $fillable     = [
        'id_kordinator_pengasuh',
        'id',
    ];
}
