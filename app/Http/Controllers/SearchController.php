<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Album;
use App\Models\User;
use App\Models\Playlist;
use App\Models\Review;
use App\Models\ForumTopic;
use App\Models\Event;

class SearchController extends Controller
{
    /**
     * Handle global search across multiple models.
     */
    public function search(Request $request)
    {
        $q = $request->input('q');
        $songs = Song::where('title', 'like', "%{$q}%")
                     ->orWhere('artist', 'like', "%{$q}%")
                     ->get();
        $albums = Album::where('title', 'like', "%{$q}%")
                       ->orWhere('artist', 'like', "%{$q}%")
                       ->get();
        $users = User::where('name', 'like', "%{$q}%")
                     ->orWhere('email', 'like', "%{$q}%")
                     ->get();
        $playlists = Playlist::where('name', 'like', "%{$q}%")->get();
        $reviews = Review::where('text', 'like', "%{$q}%")->get();
        $topics = ForumTopic::where('title', 'like', "%{$q}%")->get();
        $events = Event::where('title', 'like', "%{$q}%")
                       ->orWhere('description', 'like', "%{$q}%")
                       ->get();

        return view('search.results', compact(
            'q', 'songs', 'albums', 'users', 'playlists', 'reviews', 'topics', 'events'
        ));
    }
}
