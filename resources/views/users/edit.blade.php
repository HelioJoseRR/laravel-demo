@extends('layouts.app')

@section('content')
<div class="main-content">
    <h1 class="main-title">Edit Profile</h1>
    
    <div class="profile-edit-container">
        <form method="POST" action="/profile/edit/{{ $user->id }}" class="profile-edit-form">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control" rows="4" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                <div class="form-text">Share a bit about your musical interests and preferences.</div>
                @error('bio')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="/profile/{{ $user->id }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
        
        <!-- Seção adicional para futuras funcionalidades -->
        <div class="profile-edit-sidebar">
            <div class="profile-edit-card">
                <h3 class="profile-edit-card-title">Profile Tips</h3>
                <ul class="profile-tips-list">
                    <li><i class="fas fa-check"></i> Use a clear and recognizable name</li>
                    <li><i class="fas fa-check"></i> Write a bio that reflects your music taste</li>
                    <li><i class="fas fa-check"></i> Keep your email updated for notifications</li>
                </ul>
            </div>
            
            <div class="profile-edit-card">
                <h3 class="profile-edit-card-title">Account Stats</h3>
                <div class="profile-stats">
                    <div class="profile-stat">
                        <span class="profile-stat-number">{{ $user->friends()->count() }}</span>
                        <span class="profile-stat-label">Friends</span>
                    </div>
                    <div class="profile-stat">
                        <span class="profile-stat-number">{{ $user->created_at->format('M Y') }}</span>
                        <span class="profile-stat-label">Member Since</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
@endsection
