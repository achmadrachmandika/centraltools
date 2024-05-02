<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;

    protected $fillable = [
            'no_spm',
            'no_bprm',
            'no_bpm',
            'message',
            'status', // Kolom status dengan default 'unread'
    ];
    
}
