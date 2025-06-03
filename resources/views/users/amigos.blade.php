@extends('layouts.app')

@section('content')
<div class="main-content">
    <h1 class="main-title">Gerenciamento de Amizades</h1>

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
    
    <!-- Convites Pendentes -->
    <section class="section-friends-pending">
        <h2 class="section-title">Convites Pendentes ({{ $pendingRequests->count() }})</h2>
        
        @if($pendingRequests->count() > 0)
            <div class="friends-pending-list">
                @foreach($pendingRequests as $request)
                    <div class="friend-request-card">
                        <div class="friend-request-info">
                            <div class="friend-avatar-wrapper">
                                <img class="friend-avatar" src="https://placehold.co/60" alt="Avatar">
                            </div>
                            <div class="friend-details">
                                <h3 class="friend-name">{{ $request->user->name }}</h3>
                                <p class="friend-email">{{ $request->user->email }}</p>
                                <p class="friend-date">Enviado em {{ $request->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="friend-actions">
                            <form action="{{ route('amigos.aceitar', $request->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Aceitar
                                </button>
                            </form>
                            <form action="{{ route('amigos.rejeitar', $request->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Rejeitar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox empty-icon"></i>
                <p class="empty-text">Você não tem convites pendentes.</p>
            </div>
        @endif
    </section>
    
    <!-- Amigos Atuais -->
    <section class="section-friends-current">
        <h2 class="section-title">Meus Amigos ({{ $friends->count() }})</h2>
        
        @if($friends->count() > 0)
            <div class="friends-current-list">
                @foreach($friends as $friend)
                    <div class="friend-card">
                        <div class="friend-card-content">
                            <div class="friend-avatar-wrapper">
                                <img class="friend-avatar" src="https://placehold.co/60" alt="Avatar">
                            </div>
                            <div class="friend-info">
                                <h3 class="friend-name">{{ $friend->name }}</h3>
                                <p class="friend-email">{{ $friend->email }}</p>
                                <a href="/profile/{{ $friend->id }}" class="friend-profile-link">
                                    <i class="fas fa-user"></i> Ver Perfil
                                </a>
                            </div>
                        </div>
                        <div class="friend-actions">
                            <form action="{{ route('amigos.remover', $friend->id) }}" method="POST" 
                                  onsubmit="return confirm('Tem certeza que deseja remover esta amizade?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-user-minus"></i> Remover
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-user-plus empty-icon"></i>
                <p class="empty-text">Você ainda não tem amigos.</p>
                <p class="empty-subtext">Que tal enviar alguns convites?</p>
            </div>
        @endif
    </section>
    
    <!-- Adicionar Novos Amigos -->
    <section class="section-add-friends">
        <h2 class="section-title">Adicionar Novos Amigos</h2>
        
        @if($potentialFriends->count() > 0)
            <div class="potential-friends-list">
                @foreach($potentialFriends as $user)
                    <div class="potential-friend-card">
                        <div class="potential-friend-content">
                            <div class="friend-avatar-wrapper">
                                <img class="friend-avatar" src="https://placehold.co/60" alt="Avatar">
                            </div>
                            <div class="potential-friend-info">
                                <h3 class="friend-name">{{ $user->name }}</h3>
                                <p class="friend-email">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="potential-friend-actions">
                            <a href="/profile/{{ $user->id }}" class="btn btn-secondary">
                                <i class="fas fa-eye"></i> Ver Perfil
                            </a>
                            <form action="{{ route('amigos.enviar') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                <button type="submit" class="btn">
                                    <i class="fas fa-user-plus"></i> Enviar Convite
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-users empty-icon"></i>
                <p class="empty-text">Não há usuários disponíveis para adicionar como amigos.</p>
                <p class="empty-subtext">Todos os usuários já são seus amigos ou têm convites pendentes!</p>
            </div>
        @endif
    </section>
</div>
@endsection
