<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Beat;

class GenreController extends Controller
{
    public function index()
    {
        return response()->json(Genre::orderBy('name')->get());
    }

    public function show(Genre $genre)
    {
        $beats = Beat::where('genre_id', $genre->id)
            ->with(['genre', 'user', 'licenses.assets'])
            ->latest()
            ->get();

        return response()->json([
            'genre' => $genre,
            'beats' => $beats,
        ]);
    }
}
