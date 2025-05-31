@extends('layouts.app')

@section('title', 'Songs')

@section('content')
<div class="main-content songs-container">
    <h1 class="main-title">Songs</h1>
    <ul class="song-list">
        @foreach ($songs as $song)
        <li class="song-card">
            <span class="song-title">{{ $song->title }}</span>
            <span class="song-artist">by {{ $song->artist }}</span>
            @if ($song->album_title)
            <span class="song-album">(Album: {{ $song->album_title }})</span>
            @endif
        </li>
        @endforeach
    </ul>
    @if ($songs->hasPages())
        <div class="simple-pagination">
            @if ($songs->onFirstPage())
                <span class="simple-page-link disabled">&lt;</span>
            @else
                <a class="simple-page-link" href="{{ $songs->previousPageUrl() }}">&lt;</a>
            @endif
            <span class="simple-page-info">Página {{ $songs->currentPage() }} de {{ $songs->lastPage() }}</span>
            @if ($songs->hasMorePages())
                <a class="simple-page-link" href="{{ $songs->nextPageUrl() }}">&gt;</a>
            @else
                <span class="simple-page-link disabled">&gt;</span>
            @endif
        </div>
    @endif
</div>
@endsection