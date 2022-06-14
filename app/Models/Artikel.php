<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'isi', 'pengisi',
    ];

    public function pengisi()
    {
        return $this->belongsTo('App\Model\User');
    }
}
