<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Album;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::with('album')->orderBy('created_at', 'desc')->paginate(10); // Use paginate instead of get
        $albums = Album::all();
        return view('songs.index', compact('songs', 'albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // load albums for selection
        $albums = Album::all();
        return view('songs.create', compact('albums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'album_id' => 'required|integer|exists:albums,id',
            'genre' => 'nullable|string|max:100',
            'duration' => 'required|integer|min:1',
        ]);

        Song::create($data);
        return redirect('/songs')->with('success', 'Song added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $song = Song::findOrFail($id);
        $albums = Album::all();
        return view('songs.edit', compact('song', 'albums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $song = Song::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'album_id' => 'required|integer|exists:albums,id',
            'genre' => 'nullable|string|max:100',
            'duration' => 'required|integer|min:1',
        ]);
        $song->update($data);
        return redirect('/songs')->with('success', 'Song updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $song = Song::findOrFail($id);
        // Prevent deleting the last song of an album
        $album = $song->album;
        if ($album->songs()->count() <= 1) {
            return redirect('/songs')->with('error', 'Cannot delete the last song of an album.');
        }
        $song->delete();
        return redirect('/songs')->with('success', 'Song deleted successfully.');
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index']);
    }
}
