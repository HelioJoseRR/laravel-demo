@extends('layouts.app')

@section('content')
<div class="main-content playlist-create-container">
    <h1 class="main-title">New Playlist</h1>
    <form class="playlist-create-form" action="/playlists" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Playlist Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <h3 class="section-title">Select Songs</h3>
        <div class="form-group">
            <label class="form-label">Songs</label>
            <select name="song_ids[]" class="form-control" multiple required>
                @foreach($availableSongs as $song)
                    <option value="{{ $song->id }}">{{ $song->title }} by {{ $song->artist }}</option>
                @endforeach
            </select>
            <small class="form-text">Hold Ctrl (Cmd) to select multiple songs.</small>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="/playlists" class="btn btn-secondary" style="margin-left:0.7rem;">Cancel</a>
    </form>
</div>
@endsection