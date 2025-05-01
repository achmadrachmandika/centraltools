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

}
