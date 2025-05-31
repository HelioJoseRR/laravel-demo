@extends('layouts.app')

@section('content')
<div class="main-content event-create-container">
  <h1 class="main-title">New Event</h1>
  <form class="event-create-form" action="/events" method="POST">
    @csrf
    <div class="form-group">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="form-group">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <label class="form-label">Event Date</label>
      <input type="date" name="event_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
    <a href="/events" class="btn btn-secondary" style="margin-left:0.7rem;">Cancel</a>
  </form>
</div>
@endsection