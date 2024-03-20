<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeMaterial extends Model
{
    use HasFactory;

    protected $table = 'kode_materials'; // Menyesuaikan nama tabel dengan migrasi

    protected $primaryKey = 'kode_material'; // Menyesuaikan primary key
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'kode_material',
        'spek',
        'keterangan',
    ];
}
