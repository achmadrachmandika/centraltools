<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BpmMaterial extends Model
{
       use HasFactory;

    protected $table = 'bpm_materials';

    protected $fillable = [
     'no_bpm',
        'material_id', // Pastikan ini digunakan, bukan kode_material
        'jumlah_material',
        'satuan_material',
    ];

    public function bpm()
    {
        return $this->belongsTo(Bpm::class, 'no_bpm', 'id');
    }

    public function material()
{
    return $this->belongsTo(Material::class, 'material_id');
}




      public function getKodeMaterialAttribute()
    {
        return $this->material ? $this->material->kode_material : null;
    }
}
