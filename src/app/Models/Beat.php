<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'bpm',
        'key',
        'genre_id',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'bpm' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(BeatLicense::class);
    }
}