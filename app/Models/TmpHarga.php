<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpHarga extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal', 'harga',
    ];

    protected $casts = [
        'tanggal' => 'datetime'
    ];

    
}
