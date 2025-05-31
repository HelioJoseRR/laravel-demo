@extends('layouts.app')

@section('content')
<div class="main-content albums-container">
    <h1 class="main-title">Albums</h1>
    <!-- Creation of albums is handled in backend, UI disabled -->
    <div class="table-responsive">
    <table class="albums-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Release Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
            <tr>
                <td>{{ $album->title }}</td>
                <td>{{ $album->artist }}</td>
                <td>{{ $album->release_date->format('Y-m-d') }}</td>
                <td>
                    <a href="/albums/view/{{ $album->id }}" class="btn btn-secondary">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection