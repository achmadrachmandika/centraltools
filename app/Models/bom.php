<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\SoftDeletes;

class bom extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'boms'; 
    protected $primaryKey = 'nomor_bom'; 

    protected $fillable = [

        'nomor_bom', // Mengubah menjadi bigIncrements
        'project',
        'tgl_permintaan',
        'keterangan'
    ];
     public function kodeMaterial()
    {
        return $this->belongsTo(Material::class, 'kode_material', 'kode_material');
    }

    // Tentukan atribut yang ingin dilog
    protected static $logAttributes = ['*']; // Menggunakan '*' untuk semua atribut

    // Menentukan log name
    protected static $logName = 'BOM';

    // Log hanya perubahan yang terjadi
    protected static $logOnlyDirty = true;

    // Menampilkan log perubahan atribut
    protected static $logAttributesToIgnore = ['updated_at'];

    // Implementasikan getActivitylogOptions
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Log semua atribut
            ->useLogName(self::$logName)
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    // Custom description untuk log
    public function getDescriptionForEvent(string $eventName): string
    {
        return "The " . self::$logName . " with ID {$this->nomor_bom} has been {$eventName}";
    }
}
