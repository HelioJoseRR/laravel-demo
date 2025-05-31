@extends('layouts.app')

@section('content')


<div >
    <div >
        <h1>{{ $album->title }}</h1>
        <p><strong>Artist:</strong> {{ $album->artist }}</p>
        <p><strong>Release Date:</strong> {{ $album->release_date->format('Y-m-d') }}</p>
    </div>

    <hr>

    <div >
        <h3>Songs</h3>
        <ul >
            @foreach($songs as $song)
                <li >
                    <span>{{ $song->title }} by {{ $song->artist }}</span>
                    @if($song->genre)
                        <span >{{ $song->genre }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <div class="add-song-form">
        <h4>Add Song</h4>
        <form action="/albums/add-song" method="POST">
            @csrf
            <input type="hidden" name="album_id" value="{{ $album->id }}">
            <div >
                <label class="form-label">Title</label>
                <input type="text" name="title"  required>
            </div>
            <div >
                <label class="form-label">Artist</label>
                <input type="text" name="artist"  required>
            </div>
            <div >
                <label class="form-label">Genre</label>
                <input type="text" name="genre" >
            </div>
            <button type="submit" >Add Song</button>
        </form>
    </div>

    <a href="/albums" >Back to Albums</a>
</div>
@endsection