@extends('layouts.app')

@section('content')
<div >
    <h1>Edit Event</h1>
    <form action="/events/edit/{{ $event->id }}" method="POST">
        @csrf
        <div >
            <label class="form-label">Title</label>
            <input type="text" name="title"  value="{{ $event->title }}" required>
        </div>
        <div >
            <label class="form-label">Description</label>
            <textarea name="description" >{{ $event->description }}</textarea>
        </div>
        <div >
            <label class="form-label">Event Date</label>
            <input type="date" name="event_date"  value="{{ $event->event_date }}" required>
        </div>
        <button type="submit" >Update</button>
        <a href="/events" >Cancel</a>
    </form>
</div>
@endsection