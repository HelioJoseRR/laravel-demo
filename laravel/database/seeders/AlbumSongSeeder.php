<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\Song;

class AlbumSongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $albums = [
            [
                'title' => 'Album 1',
                'artist' => 'Artist 1',
                'release_date' => '2023-01-01',
                'songs' => [
                    ['title' => 'Song 1', 'artist' => 'Artist 1', 'genre' => 'Pop', 'duration' => 210],
                    ['title' => 'Song 2', 'artist' => 'Artist 1', 'genre' => 'Rock', 'duration' => 180],
                ],
            ],
            [
                'title' => 'Album 2',
                'artist' => 'Artist 2',
                'release_date' => '2023-02-01',
                'songs' => [
                    ['title' => 'Song 3', 'artist' => 'Artist 2', 'genre' => 'Jazz', 'duration' => 240],
                    ['title' => 'Song 4', 'artist' => 'Artist 2', 'genre' => 'Blues', 'duration' => 200],
                ],
            ],
        ];

        foreach ($albums as $albumData) {
            $album = Album::create([
                'title' => $albumData['title'],
                'artist' => $albumData['artist'],
                'release_date' => $albumData['release_date'],
            ]);

            foreach ($albumData['songs'] as $songData) {
                Song::create(array_merge($songData, ['album_id' => $album->id]));
            }
        }
    }
}
