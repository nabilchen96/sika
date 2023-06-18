<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $primaryKey = 'id_berita';
    protected $fillable     = [
        'judul_berita',
        'isi_berita',
        'id',
        'kategori',
        'gambar_utama',
        'input_lamaran'
    ];
}
