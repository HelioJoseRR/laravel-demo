@extends('layouts.app')

@section('content')
<div class="main-content event-view-container">
    <h1 class="main-title">{{ $event->title }}</h1>
    <p class="event-meta"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}</p>
    <p class="event-meta"><strong>Created By:</strong> {{ $event->user->name ?? $event->user->username }}</p>
    @if($event->description)
    <hr>
    <p class="event-description">{{ $event->description }}</p>
    @endif
    
    <div class="event-actions" style="margin-top:1.5rem;">
        @auth
            @if($event->user_id === Auth::id())
                <a href="/events/edit/{{ $event->id }}" class="btn btn-secondary">Edit</a>
                <form action="/events/delete/{{ $event->id }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Delete this event?')">Delete</button>
                </form>
            @endif
        @endauth
        <a href="/events" class="btn btn-secondary" style="margin-left:0.7rem;">Back to Events</a>
    </div>
</div>
@endsection