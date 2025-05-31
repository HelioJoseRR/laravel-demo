@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Profile</h1>
    <form method="POST" action="/profile/edit/{{ $user->id }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Bio</label>
            <textarea name="bio" class="form-control" rows="3">{{ old('bio', $user->bio) }}</textarea>
            @error('bio')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="/profile/{{ $user->id }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection