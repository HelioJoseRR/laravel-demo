<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Song;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $albums = Album::orderBy('created_at', 'desc')->get();
        return view('albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('albums.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'release_date' => 'required|date',
            // require at least one song for new album
            'song_title' => 'required|string|max:255',
            'song_artist' => 'required|string|max:255',
            'song_genre' => 'nullable|string|max:100',
        ]);
        // create album and initial song
        $album = Album::create([
            'title' => $data['title'],
            'artist' => $data['artist'],
            'release_date' => $data['release_date'],
        ]);
        Song::create([
            'title' => $data['song_title'],
            'artist' => $data['song_artist'],
            'album_id' => $album->id,
            'genre' => $data['song_genre'] ?? null,
        ]);
        return redirect('/albums/view/' . $album->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $album = Album::findOrFail($id);
        $songs = Song::where('album_id', $id)->get();
        return view('albums.show', compact('album', 'songs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $album = Album::findOrFail($id);
        return view('albums.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $album = Album::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'release_date' => 'required|date',
        ]);
        $album->update($data);
        return redirect('/albums');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $album = Album::findOrFail($id);
        if ($album->songs()->count() > 0) {
            return redirect('/albums')->with('error', 'Cannot delete album with songs.');
        }
        $album->delete();
        return redirect('/albums')->with('success', 'Album deleted successfully.');
    }

    /**
     * Add song to album.
     */
    public function addSong(Request $request)
    {
        $data = $request->validate([
            'album_id' => 'required|integer|exists:albums,id',
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
        ]);
        Song::create([
            'title' => $data['title'],
            'artist' => $data['artist'],
            'album_id' => $data['album_id'],
            'genre' => $data['genre'] ?? null,
        ]);
        return redirect("/albums/view/{$data['album_id']}");
    }
}
