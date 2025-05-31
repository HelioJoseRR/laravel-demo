@extends('layouts.app')

@section('title', 'Playlists')

@section('content')
<div class="main-content playlists-container">
    <h1 class="main-title">Playlists</h1>
    @auth
    <a href="/playlists/create" class="btn btn-primary" style="margin-bottom:1.5rem;">Create New Playlist</a>
    @endauth
    <ul class="playlist-list">
        @foreach ($playlists as $playlist)
        <li class="playlist-card">
            <a href="/playlists/view/{{ $playlist->id }}" class="playlist-title">{{ $playlist->name }}</a>
            <small class="playlist-author">by {{ $playlist->username }}</small>
        </li>
        @endforeach
    </ul>
    <div class="playlist-pagination">
      {{ $playlists->links() }}
    </div>
</div>
@endsection