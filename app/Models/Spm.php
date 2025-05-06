<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spm extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'spms';
    protected $primaryKey = 'no_spm';

    protected $fillable = [
        'no_spm',
        'project',
        'bagian',
        'nama_admin',
        'lokasi',
        'tgl_spm',
        'keterangan_spm',
    ];

    // Relasi ke tabel spm_materials
    public function materials()
    {
        return $this->hasMany(SpmMaterial::class, 'no_spm', 'no_spm');
    }

    protected static $logAttributes = ['*'];
    protected static $logName = 'SPM';
    protected static $logOnlyDirty = true;
    protected static $logAttributesToIgnore = ['updated_at'];

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
        return "The " . self::$logName . " with ID {$this->no_spm} has been {$eventName}";
    }
}

