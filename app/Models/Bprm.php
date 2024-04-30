<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;

class Bprm extends Model
{
    use HasFactory;

    protected $table = 'bprms'; // Menyesuaikan nama tabel dengan migrasi

    protected $primaryKey = 'no_bprm'; // Menyesuaikan primary key
     public $incrementing = false;
     protected $keyType = 'bigInteger';
    protected $fillable = [
        'no_bprm',
        'no_spm',
        'project',
        'tgl_bprm',
        'nama_material_1',
        'kode_material_1',
        'spek_material_1',
        'jumlah_material_1',
        'satuan_material_1',
        'nama_material_2',
        'kode_material_2',
        'spek_material_2',
        'jumlah_material_2',
        'satuan_material_2',
        'nama_material_3',
        'kode_material_3',
        'spek_material_3',
        'jumlah_material_3',
        'satuan_material_3',
        'nama_material_4',
        'kode_material_4',
        'spek_material_4',
        'jumlah_material_4',
        'satuan_material_4',
        'nama_material_5',
        'kode_material_5',
        'spek_material_5',
        'jumlah_material_5',
        'satuan_material_5',
        'nama_material_6',
        'kode_material_6',
        'spek_material_6',
        'jumlah_material_6',
        'satuan_material_6',
        'nama_material_7',
        'kode_material_7',
        'spek_material_7',
        'jumlah_material_7',
        'satuan_material_7',
        'nama_material_8',
        'kode_material_8',
        'spek_material_8',
        'jumlah_material_8',
        'satuan_material_8',
        'nama_material_9',
        'kode_material_9',
        'spek_material_9',
        'jumlah_material_9',
        'satuan_material_9',
        'nama_material_10',
        'kode_material_10',
        'spek_material_10',
        'jumlah_material_10',
        'satuan_material_10',
    ];  
      // Definisikan relasi dengan model KodeMaterialz
    public function kodeMaterial()
    {
        return $this->belongsTo(Material::class, 'kode_material', 'kode_material');
    }
}
