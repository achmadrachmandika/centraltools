<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmMaterial extends Model
{
    use HasFactory;

    protected $table = 'spm_materials';

    protected $fillable = [
        'no_spm',
        'kode_material',
        'spek_material',
        'jumlah_material',
        'satuan_material',
    ];

    public function spm()
    {
        return $this->belongsTo(Spm::class, 'no_spm', 'no_spm');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'kode_material', 'kode_material');
    }
}
