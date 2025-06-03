<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Removido: use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // Removido: use HasApiTokens;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    /**
     * Amizades que o usuário iniciou
     */
    public function sentFriendRequests()
    {
        return $this->hasMany(Amigo::class, 'user_id');
    }
    
    /**
     * Amizades que o usuário recebeu
     */
    public function receivedFriendRequests()
    {
        return $this->hasMany(Amigo::class, 'friend_id');
    }
    
    /**
     * Obter todos os amigos aceitos
     */
    public function friends()
    {
        $sentAccepted = $this->sentFriendRequests()
            ->where('status', 'accepted')
            ->with('friend')
            ->get()
            ->pluck('friend');
            
        $receivedAccepted = $this->receivedFriendRequests()
            ->where('status', 'accepted')
            ->with('user')
            ->get()
            ->pluck('user');
            
        return $sentAccepted->merge($receivedAccepted);
    }
    
    /**
     * Obter convites de amizade pendentes
     */
    public function pendingFriendRequests()
    {
        return $this->receivedFriendRequests()
            ->where('status', 'pending')
            ->with('user')
            ->get();
    }
}
