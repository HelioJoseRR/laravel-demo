@extends('layouts.app')

@section('title', "Search: '" . $q . "'")

@section('content')
<div class="main-content search-results-container">
  <h1 class="main-title">Results for "{{ $q }}"</h1>

  <section class="search-section">
    <h2 class="section-title">Songs</h2>
    @if($songs->isEmpty())
      <p class="search-empty">No songs found.</p>
    @else
      <ul class="search-list">
        @foreach($songs as $song)
          <li class="search-list-item">
            <a href="{{ url('/songs') }}?filter={{ $song->id }}" class="search-link">{{ $song->title }} <span class="search-list-meta">by {{ $song->artist }}</span></a>
          </li>
        @endforeach
      </ul>
    @endif
  </section>

  <section class="search-section">
    <h2 class="section-title">Albums</h2>
    @if($albums->isEmpty())
      <p class="search-empty">No albums found.</p>
    @else
      <div class="search-album-list">
        @foreach($albums as $album)
          <div class="search-album-card">
            <h5 class="search-album-title">{{ $album->title }}</h5>
            <p class="search-album-meta">by {{ $album->artist }}</p>
            <a href="{{ url('/albums/view/'.$album->id) }}" class="search-link">View Album</a>
          </div>
        @endforeach
      </div>
    @endif
  </section>

  <section class="search-section">
    <h2 class="section-title">Playlists</h2>
    @if($playlists->isEmpty())
      <p class="search-empty">No playlists found.</p>
    @else
      <ul class="search-list">
        @foreach($playlists as $playlist)
          <li class="search-list-item">
            <a href="{{ url('/playlists/view/'.$playlist->id) }}" class="search-link">{{ $playlist->name }}</a>
          </li>
        @endforeach
      </ul>
    @endif
  </section>

  <section class="search-section">
    <h2 class="section-title">Users</h2>
    @if($users->isEmpty())
      <p class="search-empty">No users found.</p>
    @else
      <ul class="search-list">
        @foreach($users as $user)
          <li class="search-list-item">
            <a href="{{ url('/profile/'.$user->id) }}" class="search-link">{{ $user->name }}</a>
          </li>
        @endforeach
      </ul>
    @endif
  </section>

  <section class="search-section">
    <h2 class="section-title">Reviews</h2>
    @if($reviews->isEmpty())
      <p class="search-empty">No reviews found.</p>
    @else
      <ul class="search-list">
        @foreach($reviews as $review)
          <li class="search-list-item">
            <span class="search-review-text">{{ \Illuminate\Support\Str::limit($review->text, 80) }}</span>
            <small class="search-list-meta">by <a href="{{ url('/profile/'.$review->user_id) }}" class="search-link">{{ $review->user->name }}</a></small>
          </li>
        @endforeach
      </ul>
    @endif
  </section>

  <section class="search-section">
    <h2 class="section-title">Forum Topics</h2>
    @if($topics->isEmpty())
      <p class="search-empty">No topics found.</p>
    @else
      <ul class="search-list">
        @foreach($topics as $topic)
          <li class="search-list-item">
            <a href="{{ url('/forum/topic/'.$topic->id) }}" class="search-link">{{ $topic->title }}</a>
          </li>
        @endforeach
      </ul>
    @endif
  </section>

  <section class="search-section">
    <h2 class="section-title">Events</h2>
    @if($events->isEmpty())
      <p class="search-empty">No events found.</p>
    @else
      <ul class="search-list">
        @foreach($events as $event)
          <li class="search-list-item">
            <a href="{{ url('/events/view/'.$event->id) }}" class="search-link">{{ $event->title }}</a> <span class="search-list-meta">({{ $event->date ?? 'Date TBA' }})</span>
          </li>
        @endforeach
      </ul>
    @endif
  </section>
</div>
@endsection
