<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\SoftDeletes;

class sparepartBom extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;


    protected $fillable = [
        'nomor_bom',
        'no_material_pada_bom',
        'no',
        'desc_material',
        'kode_material',
        'spek_material',
        'qty_fab',
        'qty_fin',
        'total_material',
        'satuan_material',
        'keterangan',
        'revisi'
    ];

        // Tentukan atribut yang ingin dilog
        protected static $logAttributes = ['*']; // Menggunakan '*' untuk semua atribut

        // Menentukan log name
        protected static $logName = 'Bom Material';
    
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
            return "The " . self::$logName . " with ID {$this->kode_material} has been {$eventName}";
        }
    
}
