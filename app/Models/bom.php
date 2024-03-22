<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bom extends Model
{
    use HasFactory;

    protected $table = 'boms'; 

    protected $fillable = [

    'kode_material',
            'kode_project',
            'nama',
            'spek',
            'jumlah',
            'satuan',
    ];
}
