<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bprm extends Model
{
    use HasFactory;

    protected $table = 'bprms'; // Menyesuaikan nama tabel dengan migrasi

    protected $primaryKey = 'no_konversi'; // Menyesuaikan primary key
     public $incrementing = false;
     protected $keyType = 'bigInteger';
    protected $fillable = [
        'no_konversi',
        'nomor_bpm',
        'oka',
        'no_bprm',
        'jumlah_bprm',
        'tgl_bprm',
        'head_number',
    ];
}
