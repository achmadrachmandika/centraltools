<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sparepartBom extends Model
{
    use HasFactory;


    protected $fillable = [
        'nomor_bom',
        'no_material_pada_bom',
        'no',
        'desc_material',
        'kode_material',
        'spek_material',
        'qty_fab',
        'qty_fin',
        'total_material',
        'satuan_material',
        'keterangan',
        'revisi'
    ];

    
}
