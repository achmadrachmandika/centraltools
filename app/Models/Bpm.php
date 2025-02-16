<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\SoftDeletes;


class Bpm extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'bpms'; 
    protected $primaryKey = 'no_bpm'; 

    protected $fillable = [
        'no_bpm',
        'project',
        'bagian',
        'tgl_permintaan',
        'nama_material_1',
        'kode_material_1',
        'spek_material_1',
        'jumlah_material_1',
        'satuan_material_1',
        'nama_material_2',
        'kode_material_2',
        'spek_material_2',
        'jumlah_material_2',
        'satuan_material_2',
        'nama_material_3',
        'kode_material_3',
        'spek_material_3',
        'jumlah_material_3',
        'satuan_material_3',
        'nama_material_4',
        'kode_material_4',
        'spek_material_4',
        'jumlah_material_4',
        'satuan_material_4',
        'nama_material_5',
        'kode_material_5',
        'spek_material_5',
        'jumlah_material_5',
        'satuan_material_5',
        'nama_material_6',
        'kode_material_6',
        'spek_material_6',
        'jumlah_material_6',
        'satuan_material_6',
        'nama_material_7',
        'kode_material_7',
        'spek_material_7',
        'jumlah_material_7',
        'satuan_material_7',
        'nama_material_8',
        'kode_material_8',
        'spek_material_8',
        'jumlah_material_8',
        'satuan_material_8',
        'nama_material_9',
        'kode_material_9',
        'spek_material_9',
        'jumlah_material_9',
        'satuan_material_9',
        'nama_material_10',
        'kode_material_10',
        'spek_material_10',
        'jumlah_material_10',
        'satuan_material_10',
    ];  
      // Definisikan relasi dengan model KodeMaterialz
    public function kodeMaterial()
    {
        return $this->belongsTo(Material::class, 'kode_material', 'kode_material');
    }

         public function materials()
    {
        return $this->hasMany(Material::class, 'kode_material', 'kode_material');
    }

    // Tentukan atribut yang ingin dilog
    protected static $logAttributes = ['*']; // Menggunakan '*' untuk semua atribut

    // Menentukan log name
    protected static $logName = 'BPM';

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
        return "The " . self::$logName . " with ID {$this->no_bpm} has been {$eventName}";
    }
}
