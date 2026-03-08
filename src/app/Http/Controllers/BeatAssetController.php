<?php

namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\BeatAsset;
use App\Models\BeatLicense;
use Illuminate\Http\Request;

class BeatAssetController extends Controller
{
    public function upload(Request $request, Beat $beat)
    {
        $this->assertOwner($request, $beat);

        $data = $request->validate([
            'license_code' => ['required', 'in:base,premium,exclusive'],
            'type' => ['required', 'in:mp3,wav,trackout_zip'],
            'file' => ['required', 'file', 'max:524288'], // 512MB
        ]);

        $license = $beat->licenses()->where('code', $data['license_code'])->firstOrFail();

        // правила соответствия типов к планам
        $allowed = $this->allowedTypesForLicense($license->code);
        if (!in_array($data['type'], $allowed, true)) {
            return response()->json([
                'message' => 'This file type is not allowed for this plan.',
                'allowed' => $allowed,
            ], 422);
        }

        // валидация по mime/расширению для ZIP отдельно
        $file = $request->file('file');
        if ($data['type'] === BeatAsset::TYPE_TRACKOUT_ZIP) {
            $ext = strtolower($file->getClientOriginalExtension() ?? '');
            if ($ext !== 'zip') {
                return response()->json([
                    'message' => 'Trackout must be a .zip archive.',
                ], 422);
            }
        }

        // сохраняем в s3 (MinIO)
        // пример пути: beats/{beat_id}/{license_code}/{type}/xxxx.ext
        $dir = "beats/{$beat->id}/{$license->code}/{$data['type']}";
        $path = $file->store($dir, 's3');
 
        // upsert: один тип на одну лицензию
        $asset = $license->assets()->updateOrCreate(
            ['type' => $data['type']],
            [
                'disk' => 's3',
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime' => $file->getClientMimeType(),
                'size_bytes' => $file->getSize(),
            ]
        );

        return response()->json($asset->fresh(), 201);
    }

    private function allowedTypesForLicense(string $code): array
    {
        return match ($code) {
            BeatLicense::CODE_BASE => [BeatAsset::TYPE_MP3],
            BeatLicense::CODE_PREMIUM => [BeatAsset::TYPE_MP3, BeatAsset::TYPE_WAV],
            BeatLicense::CODE_EXCLUSIVE => [BeatAsset::TYPE_WAV, BeatAsset::TYPE_TRACKOUT_ZIP],
            default => [],
        };
    }

    private function assertOwner(Request $request, Beat $beat): void
    {
        if ($beat->user_id !== $request->user()->id) {
            abort(403, 'Forbidden');
        }
    }
}