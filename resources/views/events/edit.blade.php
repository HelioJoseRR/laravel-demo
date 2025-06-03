@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="main-content event-edit-container">
    <h1 class="main-title">Edit Event</h1>
    
    <form action="/events/edit/{{ $event->id }}" method="POST" class="event-edit-form">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ $event->description }}</textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Event Date</label>
            <input type="date" name="event_date" class="form-control" value="{{ $event->event_date }}" required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Event</button>
            <a href="/events" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection