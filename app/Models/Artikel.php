<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'isi', 'user_id',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class,"user_id");
    }
}
