<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BprmMaterial extends Model
{
    use HasFactory;

    protected $table = 'bprm_materials'; // Nama tabel

    protected $fillable = [
        'nomor_bprm',
        'material_id', // Menggunakan material_id
        'jumlah_material',
        'satuan_material'
    ];

    public function bprm()
    {
        return $this->belongsTo(Bprm::class, 'nomor_bprm', 'nomor_bprm');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id'); // Relasi ke Material menggunakan material_id
    }

    // Mendapatkan kode_material dari relasi material
    public function getKodeMaterialAttribute()
    {
        return $this->material ? $this->material->kode_material : null;
    }
}


