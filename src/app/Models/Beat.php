<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beat extends Model
{
    use HasFactory;

    protected $fillable = [
        'genre_id',
        'user_id',
        'name',
        'description',
        'beat_location',
        'price',
    ];
}

