@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="main-content profile-container">
    <h1 class="profile-title">{{ $user->name }}'s Profile</h1>

    <!-- Reviews Section -->
    <section class="profile-section reviews-section">
        <h2 class="section-title">Reviews</h2>
        @auth
        <a href="/reviews/create" class="btn btn-primary">Write a Review</a>
        @endauth
        <div class="reviews-list">
        @foreach ($reviews as $review)
        <div class="review-card">
            <div class="review-content">
                <p class="review-text">"{{ $review->text ?? 'No comment' }}"</p>
                <span class="review-date">{{ $review->created_at ?? 'Unknown Date' }}</span>
            </div>
        </div>
        @endforeach
        </div>
        <div class="view-all-reviews">
            <a href="/reviews?user_id={{ $user->id }}" class="view-all-button"><i class="fas fa-arrow-right"></i> See all</a>
        </div>
    </section>

    <!-- Friends Section -->
    <section class="profile-section friends-section">
        <h2 class="section-title">Friends</h2>
        <div class="friends-list">
        @foreach ($friends as $friend)
        <div class="friend-card">
            <img class="friend-avatar" src="{{ $friend->profile_picture ?? 'https://placehold.co/60' }}" alt="Friend's Profile Picture">
            <div class="friend-info">
                <p class="friend-username"><strong>{{ $friend->username }}</strong></p>
                <p class="friend-last-active">Last active: {{ $friend->last_active }}</p>
            </div>
            <button class="btn btn-secondary">Message</button>
        </div>
        @endforeach
        </div>
        <div class="view-all-friends">
            <a href="/friends?user_id={{ $user->id }}" class="view-all-button"><i class="fas fa-arrow-right"></i> See all</a>
        </div>
    </section>
</div>
@endsection