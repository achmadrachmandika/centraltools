<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    use HasFactory;

    protected $table = 'projects'; // Menyesuaikan nama tabel dengan migrasi

    
    protected $fillable = [
            'nama_project',

    ];
}
