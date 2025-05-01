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
        return $this->belongsTo(Project::class, 'project_peminjam_id');
    }

    // Relasi ke project pemilik
    public function pemilik()
    {
        return $this->belongsTo(Project::class, 'project_pemilik_id');
    }

    // Relasi ke detail pinjaman
    public function details()
    {
        return $this->hasMany(ProjectMaterialLoanDetail::class, 'loan_id');
    }
}
