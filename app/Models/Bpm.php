<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KodeMaterial;


class Bpm extends Model
{
    use HasFactory;

    protected $table = 'bpms'; 
    protected $primaryKey = 'nomor_bpm'; 

    protected $fillable = [
        'nomor_bpm',
        'order_proyek',
        'kode_material',
        'jumlah_bpm',
        'satuan',
        'tgl_permintaan',
        'keterangan',
    ];  
      // Definisikan relasi dengan model KodeMaterial
    public function kodeMaterial()
    {
        return $this->belongsTo(KodeMaterial::class, 'kode_material', 'kode_material');
    }
}
