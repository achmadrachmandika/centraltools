<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bpm extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'bpms';
    protected $primaryKey = 'id'; // Gunakan id sebagai primary key

    protected $fillable = [
        'no_bpm',
        'project',
        'lokasi',
        'tgl_permintaan',
    ];

    /**
     * Relasi ke tabel bpm_materials untuk menyimpan material BPM.
     */
    public function materials()
    {
        return $this->hasMany(BpmMaterial::class, 'bpm_id', 'id');
    }
    public function bpmMaterials()
{
    return $this->hasMany(BpmMaterial::class, 'no_bpm', 'no_bpm');
}


    /**
     * Konfigurasi Logging dengan Spatie Activity Log
     */
    protected static $logAttributes = ['*']; // Log semua atribut
    protected static $logName = 'BPM';
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
        return "The BPM with ID {$this->id} has been {$eventName}";
    }
}
