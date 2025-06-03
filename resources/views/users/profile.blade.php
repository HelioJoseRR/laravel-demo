@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="main-content profile-container">
    <div class="profile-header">
        <h1 class="main-title">{{ $user->name }}'s Profile</h1>
        
        @auth
        @if(auth()->user()->id !== $user->id)
            <div class="friendship-actions">
                @if($friendshipStatus === null)
                    <form action="{{ route('amigos.enviar') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="friend_id" value="{{ $user->id }}">
                        <button type="submit" class="btn">
                            <i class="fas fa-user-plus"></i> Adicionar Amigo
                        </button>
                    </form>
                @elseif($friendshipStatus === 'pending')
                    @php
                        $pendingRequest = App\Models\Amigo::where('user_id', $user->id)
                                                         ->where('friend_id', auth()->id())
                                                         ->where('status', 'pending')
                                                         ->first();
                    @endphp
                    
                    @if($pendingRequest)
                        <div class="friendship-pending-actions">
                            <form action="{{ route('amigos.aceitar', $pendingRequest->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Aceitar Convite
                                </button>
                            </form>
                            <form action="{{ route('amigos.rejeitar', $pendingRequest->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Rejeitar
                                </button>
                            </form>
                        </div>
                    @else
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-clock"></i> Convite Enviado
                        </button>
                    @endif
                @elseif($friendshipStatus === 'accepted')
                    <form action="{{ route('amigos.remover', $user->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Tem certeza que deseja remover esta amizade?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-user-minus"></i> Remover Amizade
                        </button>
                    </form>
                @endif
            </div>
        @endif
        @endauth
    </div>

    <!-- Reviews Section -->
    <section class="profile-section reviews-section">
        <h2 class="section-title">Reviews</h2>
        @auth
        <a href="/reviews/create" class="btn">Write a Review</a>
        @endauth
        <div class="reviews-list">
        @forelse ($reviews as $review)
        <div class="review-card">
            <div class="review-content">
                <p class="review-text">"{{ $review->text ?? 'No comment' }}"</p>
                <span class="review-date">{{ $review->created_at ? $review->created_at->format('d/m/Y') : 'Unknown Date' }}</span>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <p class="empty-text">Nenhuma review encontrada.</p>
        </div>
        @endforelse
        </div>
        @if($reviews->count() > 0)
        <div class="view-all-reviews">
            <a href="/reviews?user_id={{ $user->id }}" class="view-all-button">
                <i class="fas fa-arrow-right"></i> See all
            </a>
        </div>
        @endif
    </section>

    <!-- Friends Section -->
    <section class="profile-section friends-section">
        <h2 class="section-title">Friends ({{ $friends->count() }})</h2>
        
        @if($friends->count() > 0)
            <div class="friends-list">
            @foreach ($friends as $friend)
            <div class="friend-card">
                <div class="friend-avatar-wrapper">
                    <img class="friend-avatar" src="{{ $friend->profile_picture ?? 'https://placehold.co/60' }}" alt="Friend's Profile Picture">
                </div>
                <div class="friend-info">
                    <h3 class="friend-username">{{ $friend->name }}</h3>
                    <p class="friend-email">{{ $friend->email }}</p>
                    @if($friend->updated_at)
                        <p class="friend-last-active">Last active: {{ $friend->updated_at->diffForHumans() }}</p>
                    @endif
                </div>
                <div class="friend-actions">
                    <a href="/profile/{{ $friend->id }}" class="btn btn-secondary">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    @auth
                    @if(auth()->user()->id !== $friend->id)
                    <button class="btn btn-secondary" onclick="alert('Funcionalidade de mensagem em desenvolvimento')">
                        <i class="fas fa-envelope"></i> Message
                    </button>
                    @endif
                    @endauth
                </div>
            </div>
            @endforeach
            </div>
            
            <div class="view-all-friends">
                @auth
                @if(auth()->user()->id === $user->id)
                    <a href="/amigos" class="view-all-button">
                        <i class="fas fa-users-cog"></i> Gerenciar Amigos
                    </a>
                @else
                    <a href="/amigos" class="view-all-button">
                        <i class="fas fa-arrow-right"></i> Ver todos os amigos
                    </a>
                @endif
                @else
                <a href="/login" class="view-all-button">
                    <i class="fas fa-sign-in-alt"></i> Login para ver amigos
                </a>
                @endauth
            </div>
        @else
            <div class="empty-state">
                @if(auth()->check() && auth()->user()->id === $user->id)
                    <i class="fas fa-user-plus empty-icon"></i>
                    <p class="empty-text">Você ainda não tem amigos.</p>
                    <a href="/amigos" class="btn">
                        <i class="fas fa-user-plus"></i> Adicionar Amigos
                    </a>
                @else
                    <i class="fas fa-users empty-icon"></i>
                    <p class="empty-text">{{ $user->name }} ainda não tem amigos públicos.</p>
                @endif
            </div>
        @endif
    </section>

    @auth
    @if(auth()->user()->id === $user->id)
    <div class="profile-actions">
        <a href="/profile/edit/{{ $user->id }}" class="btn btn-secondary">
            <i class="fas fa-edit"></i> Editar Perfil
        </a>
        <form method="POST" action="/logout" class="logout-form d-inline">
        @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
    @endif
    @endauth
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

