@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Login</h1>
        <form method="POST" action="/login" class="auth-form">
            @csrf
            @if($errors->any())
                <div class="auth-error">{{ $errors->first() }}</div>
            @endif
            <div class="auth-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>
            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary auth-btn">Login</button>
        </form>
        <div class="auth-links">
            <span>Don't have an account?</span> <a href="/register">Register</a>
        </div>
    </div>
</div>
@endsection