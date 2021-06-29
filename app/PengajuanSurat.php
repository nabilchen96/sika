<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    protected $primaryKey   = 'id_pengajuan_surat';
    protected $fillable     = [
        'id_mahasiswa', 'jenis_pengajuan', 'keterangan', 'status_pengajuan', 'id_semester', 'surat'
    ];
}
