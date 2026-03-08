<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BeatLicense extends Model
{
    use HasFactory;

    public const CODE_BASE = 'base';
    public const CODE_PREMIUM = 'premium';
    public const CODE_EXCLUSIVE = 'exclusive';

    protected $fillable = [
        'beat_id',
        'code',
        'price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function beat(): BelongsTo
    {
        return $this->belongsTo(Beat::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(BeatAsset::class, 'beat_license_id');
    }
}