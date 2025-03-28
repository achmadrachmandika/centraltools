<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bprm extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'bprms'; // Menyesuaikan nama tabel
    protected $primaryKey = 'nomor_bprm'; // Menyesuaikan primary key
    public $incrementing = false;
    protected $keyType = 'bigInteger';

    protected $fillable = [
        'nomor_bprm', 'no_spm', 'project', 'bagian', 'nama_admin', 'tgl_bprm'
    ];

    // Relasi Many-to-Many dengan Material melalui tabel pivot bprm_materials
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'bprm_materials', 'nomor_bprm', 'kode_material')
                    ->withPivot('jumlah_material', 'satuan_material')
                    ->withTimestamps();
    }
     public function BprmMaterials()
    {
        return $this->hasMany(BprmMaterial::class, 'nomor_bprm', 'nomor_bprm');
    }

    // Konfigurasi Activity Log
    protected static $logAttributes = ['*']; // Log semua perubahan atribut
    protected static $logName = 'BPRM';
    protected static $logOnlyDirty = true; // Log hanya perubahan data
    protected static $logAttributesToIgnore = ['updated_at']; // Abaikan perubahan updated_at

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName(self::$logName)
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "The " . self::$logName . " with ID {$this->nomor_bprm} has been {$eventName}";
    }
}
