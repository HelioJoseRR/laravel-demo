@extends('layouts.app')

@section('content')
<div class="forum-topic-view">
    <div class="forum-topic-header">
        <h1 class="forum-topic-title">{{ $topic->title }}</h1>
        <p class="forum-topic-meta">By {{ $topic->user->name ?? $topic->user->username }} | Created on {{ $topic->created_at->format('Y-m-d') }}</p>
    </div>
    <hr>
    <div class="forum-post-list">
    @foreach($posts as $post)
    <div class="forum-post-card">
        <p class="forum-post-text">{{ $post->text }}</p>
        <small class="forum-post-meta">by {{ $post->user->name ?? $post->user->username }} on {{ $post->created_at->format('Y-m-d') }}</small>
    </div>
    @endforeach
    </div>
    <div class="forum-reply-form-wrapper">
        <h4 style="margin-bottom:0.7rem;">Add a reply</h4>
        <form class="forum-reply-form" action="/forum/post" method="POST">
            @csrf
            <input type="hidden" name="topic_id" value="{{ $topic->id }}">
            <textarea name="content" rows="3" required placeholder="Write your reply..."></textarea>
            <button type="submit" class="btn btn-primary">Reply</button>
            <a href="/forum" class="btn btn-secondary" style="margin-left:0.7rem;">Back to Topics</a>
        </form>
    </div>
</div>
@endsection