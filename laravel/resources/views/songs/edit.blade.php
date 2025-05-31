@extends('layouts.app')

@section('content')
<div class="main-content song-edit-container">
    <h1 class="main-title">Edit Song</h1>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="song-edit-form" action="/songs/{{ $song->id }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $song->title) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Artist</label>
            <input type="text" name="artist" class="form-control" value="{{ old('artist', $song->artist) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Album</label>
            <select name="album_id" class="form-control" required>
                @foreach($albums as $album)
                    <option value="{{ $album->id }}" {{ old('album_id', $song->album_id) == $album->id ? 'selected' : '' }}>{{ $album->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Genre</label>
            <input type="text" name="genre" class="form-control" value="{{ old('genre', $song->genre) }}">
        </div>
        <div class="form-group">
            <label class="form-label">Duration (seconds)</label>
            <input type="number" name="duration" class="form-control" value="{{ old('duration', $song->duration) }}" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Song</button>
        <a href="/songs" class="btn btn-secondary" style="margin-left:0.7rem;">Cancel</a>
    </form>
</div>
@endsection