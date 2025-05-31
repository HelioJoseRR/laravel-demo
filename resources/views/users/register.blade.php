@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Register</h1>
        <form method="POST" action="/register" class="auth-form">
            @csrf
            @if($errors->any())
                <div class="auth-error">{{ $errors->first() }}</div>
            @endif
            <div class="auth-field">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required autocomplete="name">
            </div>
            <div class="auth-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autocomplete="email">
            </div>
            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autocomplete="new-password">
            </div>
            <div class="auth-field">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary auth-btn">Register</button>
        </form>
        <div class="auth-links">
            <span>Already have an account?</span> <a href="/login">Login</a>
        </div>
    </div>
</div>
@endsection