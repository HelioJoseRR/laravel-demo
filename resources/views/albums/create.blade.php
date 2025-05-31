@extends('layouts.app')

@section('content')
<div >
  <h1>Create Album</h1>
  <form action="/albums" method="POST">
    @csrf
    <div >
      <label >Title</label>
      <input type="text" name="title"  required>
    </div>
    <div >
      <label >Artist</label>
      <input type="text" name="artist"  required>
    </div>
    <div >
      <label >Release Date</label>
      <input type="date" name="release_date"  required>
    </div>
    <h3>Initial Song</h3>
    <div >
      <label >Song Title</label>
      <input type="text" name="song_title"  required>
    </div>
    <div >
      <label >Song Artist</label>
      <input type="text" name="song_artist"  required>
    </div>
    <div >
      <label >Song Genre</label>
      <input type="text" name="song_genre" >
    </div>
    <button type="submit" >Save</button>
  </form>
</div>
@endsection