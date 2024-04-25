<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bom extends Model
{
    use HasFactory;

    protected $table = 'boms'; 
    protected $primaryKey = 'nomor_bom'; 

    protected $fillable = [

        'nomor_bom', // Mengubah menjadi bigIncrements
        'project',
        'tgl_permintaan',
        'keterangan'
    ];
     public function kodeMaterial()
    {
        return $this->belongsTo(Material::class, 'kode_material', 'kode_material');
    }
}
