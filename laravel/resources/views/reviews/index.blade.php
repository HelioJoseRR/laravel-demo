@extends('layouts.app')

@section('title', 'Reviews')

@section('content')
<div class="main-content reviews-container">
    <h1 class="main-title">Reviews</h1>
    @auth
    <a href="/reviews/create" class="btn btn-primary" style="margin-bottom:1.5rem;">Create New Review</a>
    @endauth
    @if($reviews->isEmpty())
        <p class="search-empty">No reviews found.</p>
    @else
        <div class="reviews-list">
        @foreach($reviews as $review)
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
    @endif
    <div style="margin-top:2rem;">
        <a href="/" class="btn btn-secondary">Back to Home</a>
    </div>
</div>
@endsection