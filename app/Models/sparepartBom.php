<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sparepartBom extends Model
{
    use HasFactory;


    protected $fillable = [
        'nomor_bom',
        'nama_material',
        'kode_material',
        'spek_material',
        'jumlah_material',
        'satuan_material',
    ];

    
}
