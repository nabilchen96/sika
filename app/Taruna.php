<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taruna extends Model
{
    protected $primaryKey   = 'id_mahasiswa';
    protected $fillable     = [
        'id_mahasiswa_siakad', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'nama_mahasiswa', 'nim', 'id_kelas', 'nama_kelas', 'id_prodi', 
        'nama_program_studi', 'semester', 'agama', 'alamat', 'foto',
        'wali_dihubungi', 'no_wali_dihubungi', 'hubungan_wali'
    ];
}
