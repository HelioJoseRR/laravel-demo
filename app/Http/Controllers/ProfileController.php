<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Amigo;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        // Buscar reviews do usuário (assumindo que você tem um modelo Review)
        $reviews = collect(); // Substitua pela lógica real de reviews
        // $reviews = $user->reviews()->latest()->take(3)->get();
        
        // Buscar amigos do usuário (apenas os aceitos)
        $friends = $user->friends()->take(6); // Mostrar apenas 6 amigos no perfil
        
        // Verificar se o usuário logado é amigo desta pessoa
        $isFriend = false;
        $friendshipStatus = null;
        
        if (Auth::check() && Auth::id() !== $user->id) {
            $friendship = Amigo::where(function($query) use ($user) {
                    $query->where('user_id', Auth::id())
                          ->where('friend_id', $user->id);
                })
                ->orWhere(function($query) use ($user) {
                    $query->where('user_id', $user->id)
                          ->where('friend_id', Auth::id());
                })
                ->first();
                
            if ($friendship) {
                $friendshipStatus = $friendship->status;
                $isFriend = ($friendship->status === 'accepted');
            }
        }
        
        return view('users.profile', compact('user', 'reviews', 'friends', 'isFriend', 'friendshipStatus'));
    }

    public function edit($id)
    {
        // Lógica existente para editar perfil
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Lógica existente para atualizar perfil
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }
}
