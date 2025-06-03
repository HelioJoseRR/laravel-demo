@extends('layouts.app')

@section('content')
<div class="main-content playlist-view-container">
    <h1 class="main-title">{{ $playlist->name }}</h1>
    <p class="playlist-meta">Created on {{ $playlist->created_at->format('Y-m-d') }}</p>
    <hr>
    <h3 class="section-title">Songs in this Playlist</h3>
    <ul class="playlist-song-list">
        @foreach($playlist->songs as $song)
        <li class="playlist-song-item">
            <span class="playlist-song-title">{{ $song->title }}</span> <span class="playlist-song-artist">by {{ $song->artist }}</span>
            @if($song->genre) <span class="playlist-song-genre">({{ $song->genre }})</span> @endif
        </li>
        @endforeach
    </ul>
    <div class="playlist-add-song-form-wrapper">
        <h4 style="margin-bottom:0.7rem;">Add Song to Playlist</h4>
        <form class="playlist-add-song-form" action="/playlists/add-song" method="POST">
            @csrf
            <input type="hidden" name="playlist_id" value="{{ $playlist->id }}">
            <div class="mb-3">
                <label class="form-label">Song</label>
                <select name="song_id" class="form-control" required>
                    @foreach($availableSongs as $song)
                        <option value="{{ $song->id }}">{{ $song->title }} by {{ $song->artist }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add to Playlist</button>
            <a href="/playlists" class="btn btn-secondary"">Back to Playlists</a>
        </form>
    </div>
</div>
@endsection