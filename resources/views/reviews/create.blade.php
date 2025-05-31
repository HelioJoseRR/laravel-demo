@extends('layouts.app')

@section('title', 'Add Review')

@section('content')
<div class="main-content review-create-container">
    <h1 class="main-title">Add a Review</h1>
    <form action="/reviews" method="POST" class="review-create-form">
        @csrf
        <div class="form-group">
            <label for="album_id" class="form-label">Album</label>
            <select name="album_id" id="album_id" class="form-control" required>
                <option value="">-- Select Album --</option>
                @foreach($albums as $album)
                    <option value="{{ $album->id }}">{{ $album->title }} by {{ $album->artist }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="rating" class="form-label">Rating (0-5)</label>
            <input type="number" name="rating" id="rating" class="form-control" step="0.1" min="0" max="5" required>
        </div>
        <div class="form-group">
            <label for="text" class="form-label">Review</label>
            <textarea name="text" id="text" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection