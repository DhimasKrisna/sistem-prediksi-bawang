<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'harga', 'user_id',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class,"user_id");
    }


}
