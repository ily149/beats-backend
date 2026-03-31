<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Pop',
            'Rock',
            'Hip-Hop',
            'Rap',
            'Electronic',
            'Jazz',
            'Blues',
            'Classical',
            'Reggae',
            'R&B',
            'Alternative Rock',
            'Indie Rock',
            'Punk Rock',
            'Hard Rock',
            'Metal',
            'Heavy Metal',
            'Death Metal',
            'Black Metal',
            'Grunge',
            'Progressive Rock',
            'House',
            'Techno',
            'Trance',
            'Dubstep',
            'Drum and Bass',
            'EDM',
            'Ambient',
            'Chillout',
            'Lo-fi',
            'Hardstyle',
            'Trap',
            'Drill',
            'Lo-fi Hip-Hop',
            'Soul',
            'Funk',
            'Neo Soul',
            'Afrobeats',
            'K-pop',
            'J-pop',
            'Latin',
            'Folk',
            'Country',
            'Gospel',
            'Ska',
            'Zouk',
            'Bossa Nova',
            'Flamenco',
            'Synthwave',
            'Vaporwave',
            'New Age',
            'New-Jazz',
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(['name' => $genre]);
        }
    }
}