@extends('layouts.app')

@section('content')
<div class="main-content container-home">
    <section class="home-hero">
        <div class="home-hero-content">
            <h1 class="main-title">Welcome to <span class="brand-gradient">Somoteca</span></h1>
            <p class="home-hero-subtitle">Discover, review and discuss music. Explore playlists, albums, events and more!</p>
            @auth
            <a href="/playlists" class="btn btn-primary home-hero-btn">Explore Playlists</a>
            @else
            <a href="/register" class="btn btn-primary home-hero-btn">Join Now</a>
            @endauth
        </div>
    </section>

    <section class="section-highlights">
      <h2 class="section-title"><i class="fas fa-star"></i> Featured Playlists</h2>
      <div class="highlight-list">
        @foreach ($playlists as $playlist)
          <article class="highlight-card">
            <div class="highlight-info">
              <h5 class="highlight-title"><a href="/playlists/view/{{ $playlist->id }}">{{ $playlist->name }}</a></h5>
              <p class="highlight-author">by <a href="/profile/{{ $playlist->user->id }}">{{ $playlist->user->name }}</a></p>

            </div>
          </article>
        @endforeach
      </div>
    </section>

    <section class="section-events">
      <h2 class="section-title"><i class="fas fa-calendar-alt"></i> Upcoming Music Events</h2>
      <div class="event-list">
        @foreach ($events as $event)
          <article class="event-card">
            <div class="event-info">
              <h5 class="event-title"><a href="/events/view/{{ $event->id }}">{{ $event->title }}</a></h5>
              <p class="event-date">{{ $event->event_date }}</p>
            </div>
          </article>
        @endforeach
      </div>
    </section>

    <section class="section-forum">
      <h2 class="section-title"><i class="fas fa-comments"></i> Latest Forum Discussions</h2>
      <div class="forum-list">
        @foreach ($forumDiscussions as $discussion)
          <a href="/forum/topic/{{ $discussion->id }}" class="forum-link">
            <div class="forum-card">
              <h5 class="forum-title">{{ $discussion->title }}</h5>
              <small class="forum-replies">{{ $discussion->posts_count }} replies</small>
            </div>
            <p class="forum-author">Started by <i class="fas fa-user"></i> <a href="/profile/{{$discussion->user->id}}">{{ $discussion->user->name }}</a></p>
          </a>
        @endforeach
      </div>
    </section>

    <section class="section-reviews">
      <h2 class="section-title"><i class="fas fa-star-half-alt"></i> Latest Reviews</h2>
      <div class="reviews-list">
        @foreach ($reviews as $review)
        <div class="review-card">
            <img src="{{ $review->album->cover ?? 'https://placehold.co/60' }}" alt="Album Cover" class="review-album-cover">
            <div class="review-content">
                <p><span class="review-album-title">"{{ $review->album->title ?? 'Unknown Album' }}"</span> - {{ $review->album->artist ?? 'Unknown Artist' }}:
                    <span class="star-rating">
                        @for ($i = 0; $i < 5; $i++)
                            <i class="fas fa-star{{ $i < $review->rating ? '' : '-o' }}"></i>
                        @endfor
                    </span> {{ $review->rating ?? '0' }}
                </p>
                <p class="review-text">"{{ $review->text ?? 'No comment' }}"</p>
                <span class="review-date">{{ $review->created_at->format('Y-m-d') }}</span>
            </div>
        </div>
        @endforeach
      </div>
      <div class="view-all-reviews"><a href="/reviews" class="view-all-button">View all reviews <i class="fas fa-arrow-right"></i></a></div>
    </section>
</div>
@endsection