<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'nama_panitia',
        'nama_calon_siswa',
        'nama_orang_tua',
        'nomor_orang_tua',
        'nama_rekomendasi',
        'bukti_pendaftaran',
        'catatan_lain'
    ];
}
