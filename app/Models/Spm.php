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
        'nomor_konversi', #no_bpm+kode_material
        'no_spm',
        'nama_project',//kode projek
        'kode_material',
        'spek',
        'satuan',
        'no_cp',// naama projek
        'jumlah_spm',
        'tgl_spm',
        'keterangan_spm',
    ];
}
