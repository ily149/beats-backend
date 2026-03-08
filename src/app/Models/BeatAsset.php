<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeatAsset extends Model
{
    use HasFactory;

    public const TYPE_MP3 = 'mp3';
    public const TYPE_WAV = 'wav';
    public const TYPE_TRACKOUT_ZIP = 'trackout_zip';

    protected $fillable = [
        'beat_license_id',
        'type',
        'disk',
        'path',
        'original_name',
        'mime',
        'size_bytes',
    ];

    protected function casts(): array
    {
        return [
            'size_bytes' => 'integer',
        ];
    }

    public function license(): BelongsTo
    {
        return $this->belongsTo(BeatLicense::class, 'beat_license_id');
    }
}