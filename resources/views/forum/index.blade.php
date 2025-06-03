@extends('layouts.app')

@section('title', 'Forum')

@section('content')
    <div class="main-content forum-container">
        <h1 class="main-title">Forum</h1>
        @auth
            <form action="/forum/topic" method="POST" class="forum-new-topic-form mb-4">
                @csrf
                <input type="text" name="title" class="input-title" placeholder="New topic title" required>
                <textarea name="content" class="input-content" rows="4" placeholder="Write the first post..."></textarea>
                <button type="submit" class="btn btn-primary">Create Topic</button>
            </form>
        @endauth

        <ul class="forum-topic-list">
            @foreach ($topics as $topic)
                <li class="forum-topic-item">
                    <div class="forum-topic-content" style="display: flex; align-items: center; gap: 15px; ">
                        <a href="/forum/topic/{{ $topic->id }}" class="forum-topic-link">{{ $topic->title }}</a>
                        <small class="forum-topic-meta">by {{ $topic->user->name }} on
                            {{ $topic->created_at->format('Y-m-d H:i') }}</small>
                        <span class="forum-topic-replies">{{ $topic->posts_count }} replies</span>

                        @auth
                            @if($topic->user_id === Auth::id())
                                <div class="forum-topic-actions" style="margin-left: auto;">
                                    <form action="/forum/topic/{{ $topic->id }}" method="POST" class="delete-topic-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this topic? This will also delete all posts in this topic. This action cannot be undone.')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </li>


            @endforeach
        </ul>

        <div class="forum-pagination">
            {{ $topics->links() }}
        </div>
    </div>
@endsection