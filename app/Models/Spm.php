<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spm extends Model
{
    use HasFactory;
    protected $table = 'spms'; 
    protected $primaryKey = 'nomor_konversi'; 

    protected $fillable = [
        'nomor_konversi',
        'no_bpm',
        'oka',
        'kode_material',
        'spek',
        'jumlah_bpm',
        'satuan',
        'no_cp',
        'no_spm',
        'jumlah_spm',
        'tgl_spm',
        'keterangan_spm',
    ];
}
