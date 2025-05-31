@extends('layouts.app')

@section('content')
<main class="container">
    <h2>All Users</h2>
    <ul >
        @foreach($users as $user)
        <li class="list-group-item">{{ $user->name }} ({{ $user->email }})</li>
        @endforeach
    </ul>

    <h2>Featured Highlights</h2>
    <div >
        @foreach($highlights as $h)
        <div >
            <div >
                <img src="{{ $h['image'] }}" " alt="{{ $h['title'] }}">
                <div >
                    <h5 >{{ $h['title'] }}</h5>
                    <p >{{ $h['description'] }}</p>
                    <div >
                        <img src="{{ $h['user_avatar'] }}" width="24" >
                        <small>{{ $h['username'] }}</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h2>Upcoming Events</h2>
    <div >
        @foreach($events as $e)
        <div >
            <div >
                <img src="{{ $e['image'] }}" " alt="{{ $e['title'] }}">
                <div >
                    <h5 >{{ $e['title'] }}</h5>
                    <p ><small>{{ $e['date'] }}</small></p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h2>User-Curated Lists</h2>
    <div >
        @foreach($lists as $l)
        <div >
            <div >
                <img src="{{ $l['image'] }}" " alt="{{ $l['title'] }}">
                <div >
                    <h5 >{{ $l['title'] }}</h5>
                    <p ><small>by {{ $l['username'] }}</small></p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h2>Latest Forum Discussions</h2>
    <div >
        @foreach($discussions as $d)
        <a href="/forum/topic/{{ $d['id'] }}">
            <h5 >{{ $d['title'] }}</h5>
            <small>by {{ $d['username'] }} | {{ $d['replies'] }} replies</small>
        </a>
        @endforeach
    </div>
</main>
@endsection