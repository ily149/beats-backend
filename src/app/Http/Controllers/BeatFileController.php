<?php

namespace App\Http\Controllers;

use App\Models\Beat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeatFileController extends Controller
{
    public function upload(Request $request, Beat $beat)
    {
        $data = $request->validate([
            'file' => ['required', 'file', 'max:512000'], // ~500MB
        ]);

        // кладём файл в MinIO (S3)
        $path = Storage::disk('s3')->putFile('beats', $data['file']);

        // сохраняем путь в БД
        $beat->beat_location = $path;
        $beat->save();

        return response()->json([
            'ok' => true,
            'beat_id' => $beat->id,
            'key' => $path,
        ]);
    }

    public function download(Beat $beat)
    {
        if (!$beat->beat_location) {
            return response()->json(['message' => 'Файл не загружен'], 404);
        }

        $filename = ($beat->name ? preg_replace('/[^a-zA-Z0-9_\- ]+/u', '', $beat->name) : 'beat') . '.bin';

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('s3');

        return $disk->download($beat->beat_location, $filename);
    }
}