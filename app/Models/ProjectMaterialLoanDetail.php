<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMaterialLoanDetail extends Model
{
    use HasFactory;

     protected $fillable = [
        'loan_id',
        'project_material_id',
        'jumlah',
    ];

      public function loan()
    {
        return $this->belongsTo(ProjectMaterialLoan::class, 'loan_id');
    }

    public function projectMaterial()
{
    return $this->belongsTo(project_material::class, 'project_material_id');
}

public function projectPeminjam()
{
    return $this->belongsTo(Project::class, 'project_peminjam_id');
}

public function projectPemilik()
{
    return $this->belongsTo(Project::class, 'project_pemilik_id');
}

 public function projectMaterialDetail()
    {
        return $this->hasOne(ProjectMaterialLoanDetail::class, 'loan_id');
    }

}
