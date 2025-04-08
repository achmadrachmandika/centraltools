<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;

class Bagian extends Model
{
    use HasFactory;

    protected $fillable = ['nama_bagian', 'lokasi'];

    public function materials()
    {
        return $this->hasMany(Material::class, 'lokasi', 'lokasi');
    }
}
