<?php

namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\BeatLicense;
use Illuminate\Http\Request;

class BeatController extends Controller
{
    public function index(Request $request)
    {
        return Beat::query()
            ->where('user_id', $request->user()->id)
            ->with(['licenses.assets'])
            ->latest()
            ->get();
    }

    public function show(Request $request, Beat $beat)
    {
        $this->assertOwner($request, $beat);

        return $beat->load(['licenses.assets']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'bpm' => ['nullable', 'integer', 'min:1', 'max:400'],
            'key' => ['nullable', 'string', 'max:50'],
            'genre_id' => ['nullable', 'integer'],
            'prices' => ['nullable', 'array'],
            'prices.base' => ['nullable', 'numeric', 'min:0'],
            'prices.premium' => ['nullable', 'numeric', 'min:0'],
            'prices.exclusive' => ['nullable', 'numeric', 'min:0'],
        ]);

        $beat = Beat::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'bpm' => $data['bpm'] ?? null,
            'key' => $data['key'] ?? null,
            'genre_id' => $data['genre_id'] ?? null,
            'user_id' => $request->user()->id,
        ]);

        $prices = $data['prices'] ?? [];

        $beat->licenses()->createMany([
            [
                'code' => BeatLicense::CODE_BASE,
                'price' => $prices['base'] ?? 0,
                'is_active' => true,
            ],
            [
                'code' => BeatLicense::CODE_PREMIUM,
                'price' => $prices['premium'] ?? 0,
                'is_active' => true,
            ],
            [
                'code' => BeatLicense::CODE_EXCLUSIVE,
                'price' => $prices['exclusive'] ?? 0,
                'is_active' => true,
            ],
        ]);

        return response()->json($beat->load(['licenses.assets']), 201);
    }

    private function assertOwner(Request $request, Beat $beat): void
    {
        if ($beat->user_id !== $request->user()->id) {
            abort(403, 'Forbidden');
        }
    }
}