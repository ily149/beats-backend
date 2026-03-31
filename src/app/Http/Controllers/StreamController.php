<?php

namespace App\Http\Controllers;

use App\Models\BeatAsset;
use Illuminate\Support\Facades\Storage;

class StreamController extends Controller
{
    public function __invoke(BeatAsset $asset)
    {
        $disk = Storage::disk($asset->disk);

        if (!$disk->exists($asset->path)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $mime = $asset->mime ?: 'audio/mpeg';
        $size = $disk->size($asset->path);

        return response()->stream(function () use ($disk, $asset) {
            $stream = $disk->readStream($asset->path);
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Length' => $size,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
