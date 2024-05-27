<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project_material extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_material',
        'kode_project',
        'jumlah',
    ];
}
