<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogTester extends Model
{
    protected $table = 'log_tester';
    
    protected $fillable = [
        'tanggal_uji',
        'komponen_terdeteksi',
        'status'
    ];
    
    protected $casts = [
        'tanggal_uji' => 'datetime',
    ];
}
