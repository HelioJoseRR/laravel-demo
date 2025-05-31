<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Playlist;
use App\Models\ForumTopic;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_date', 'asc')->take(3)->get();
        $playlists = Playlist::with('user')->orderBy('created_at', 'desc')->take(4)->get();
        $forumDiscussions = ForumTopic::with('user')->withCount('posts')->orderBy('created_at', 'desc')->take(3)->get();
        $reviews = Review::with(['user', 'album'])->orderBy('created_at', 'desc')->take(5)->get();

        return view('home', compact('events', 'playlists', 'forumDiscussions', 'reviews'));
    }
}