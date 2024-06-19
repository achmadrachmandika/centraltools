<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import kelas Str

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects'; // Menyesuaikan nama tabel dengan migrasi

    protected $primaryKey = 'id'; // Menentukan nama primary key

    public $incrementing = false; // Tetapkan false untuk menggunakan UUID sebagai primary key

    protected $keyType = 'string'; // Tentukan tipe data primary key sebagai string

    protected $fillable = [
        'ID_Project',
        'nama_project',
    ];

    // Method untuk memastikan bahwa kolom id diisi dengan nilai UUID saat menyimpan data baru
}
