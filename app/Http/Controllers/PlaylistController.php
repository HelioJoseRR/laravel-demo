<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $playlists = Playlist::with('user') // Adicione esta linha!
                           ->where('user_id', Auth::id())
                           ->paginate(10);
        return view('playlists.index', compact('playlists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // load all songs for selection
        $availableSongs = Song::all();
        return view('playlists.create', compact('availableSongs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate playlist name and at least one song
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'song_ids' => 'required|array|min:1',
            'song_ids.*' => 'integer|exists:songs,id',
        ]);
        // create playlist and attach songs
        $playlist = Playlist::create([
            'user_id' => Auth::id(),
            'name' => $data['name'],
        ]);
        $playlist->songs()->attach($data['song_ids']);
        return redirect('/playlists')->with('success', 'Playlist created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $playlist = Playlist::with('songs')->findOrFail($id);
        //abort_if($playlist->user_id !== Auth::id(), 403);
        $availableSongs = Song::all();
        return view('playlists.show', compact('playlist', 'availableSongs'));
    }

    /**
     * Add a song to the specified playlist.
     */
    public function addSong(Request $request)
    {
        $data = $request->validate([
            'playlist_id' => 'required|integer|exists:playlists,id',
            'song_id' => 'required|integer|exists:songs,id',
        ]);
        $playlist = Playlist::findOrFail($data['playlist_id']);
        abort_if($playlist->user_id !== Auth::id(), 403);
        $playlist->songs()->attach($data['song_id']);
        return redirect("/playlists/view/{$data['playlist_id']}");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $playlist = Playlist::findOrFail($id);
        abort_if($playlist->user_id !== Auth::id(), 403);
        return view('playlists.edit', compact('playlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $playlist = Playlist::findOrFail($id);
        abort_if($playlist->user_id !== Auth::id(), 403);
        $data = $request->validate(['name' => 'required|string|max:255']);
        $playlist->update($data);
        return redirect('/playlists');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $playlist = Playlist::findOrFail($id);
        abort_if($playlist->user_id !== Auth::id(), 403);
        $playlist->delete();
        return redirect('/playlists');
    }
}
