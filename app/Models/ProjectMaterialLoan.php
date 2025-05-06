<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMaterialLoan extends Model
{
    use HasFactory;

       protected $fillable = [
        'project_peminjam_id',
        'project_pemilik_id',
        'tanggal_pinjam',
        'status',
        'tanggal_dikembalikan',
        'keterangan',
    ];

        // Relasi ke project peminjam
    public function peminjam()
    {
        return $this->belongsTo(project::class, 'project_peminjam_id');
    }

    // Relasi ke project pemilik
    public function pemilik()
    {
        return $this->belongsTo(project::class, 'project_pemilik_id');
    }

    // Relasi ke detail pinjaman
    public function details()
    {
        return $this->hasMany(ProjectMaterialLoanDetail::class, 'loan_id');
    }

     public function projectMaterials()
    {
        return $this->hasMany(project_material::class, 'kode_project', 'project_pemilik_id');
    }
    // Di model ProjectMaterialLoan
    // public function projectMaterialDetail()
    // {
    //     return $this->hasOne(ProjectMaterialLoanDetail::class, 'loan_id');
    // }

    // // Atau jika menggunakan hasMany
    // public function details()
    // {
    //     return $this->hasMany(ProjectMaterialLoanDetail::class, 'loan_id');
    // }

      public function materials()
    {
        return $this->hasManyThrough(
            Material::class, // Model yang ingin diakses (Material)
            ProjectMaterial::class, // Model penghubung (ProjectMaterial)
            'kode_project', // Foreign key di ProjectMaterial
            'id', // Foreign key di Material
            'project_pemilik_id', // Local key di ProjectMaterialLoan
            'material_id' // Local key di ProjectMaterial
        );
    }
}
