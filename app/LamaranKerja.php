<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LamaranKerja extends Model
{
    
    protected $fillable     = [
        'nama_pelamar', 'jenis_kelamin', 'nomor_telpon', 
        'email', 'alamat', 'pengalaman', 'upload_lamaran', 'id_berita'
    ];
}
