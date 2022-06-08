<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'harga', 'pengisi',
    ];

    public function pengisi()
    {
        return $this->belongsTo('App\Model\User');
    }


}
