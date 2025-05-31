@extends('layouts.app')

@section('title', 'Upcoming Events')

@section('content')
<div class="main-content events-container">
    <h1 class="main-title">Upcoming Events</h1>
    @auth
    <a href="/events/create" class="btn btn-primary" style="margin-bottom:1.5rem;">Create New Event</a>
    @endauth
    <ul class="event-list">
        @foreach($events as $event)
        <li class="event-card">
            <div class="event-info">
                <span class="event-title">{{ $event->title }}</span>
                <span class="event-date">on {{ $event->event_date }}</span>
            </div>
            <div class="event-actions">
                <a href="/events/view/{{ $event->id }}" class="btn btn-secondary">View</a>
                @auth
                @if($event->user_id === Auth::id())
                <a href="/events/edit/{{ $event->id }}" class="btn btn-secondary">Edit</a>
                <form action="/events/delete/{{ $event->id }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" style="margin-left:0.5rem;">Delete</button>
                </form>
                @endif
                @endauth
            </div>
        </li>
        @endforeach
    </ul>
    <div class="event-pagination">
      {{ $events->links() }}
    </div>
</div>
@endsection