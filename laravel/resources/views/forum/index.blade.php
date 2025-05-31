@extends('layouts.app')

@section('title', 'Forum')

@section('content')
<div class="main-content forum-container">
    <h1 class="main-title">Forum</h1>
    @auth
    <form action="/forum/topic" method="POST" class="forum-new-topic-form mb-4">
        @csrf
        <input type="text" name="title" class="input-title" placeholder="New topic title" required >
        <textarea name="content" class="input-content" rows="4" placeholder="Write the first post..."></textarea>
        <button type="submit" class="btn btn-primary">Create Topic</button>
    </form>
    @endauth

    <ul class="forum-topic-list">
        @foreach ($topics as $topic)
        <li class="forum-topic-item">
            <a href="/forum/topic/{{ $topic->id }}" class="forum-topic-link">{{ $topic->title }}</a>
            <small class="forum-topic-meta">by {{ $topic->username }} on {{ $topic->created_at }}</small>
            <span class="forum-topic-replies">{{ $topic->reply_count }} replies</span>
        </li>
        @endforeach
    </ul>

    <div class="forum-pagination">
      {{ $topics->links() }}
    </div>
</div>
@endsection