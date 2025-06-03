<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amigo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'friend_id', 'status'];
    
    /**
     * Obter o usuário que enviou o convite
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Obter o usuário que recebeu o convite
     */
    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}