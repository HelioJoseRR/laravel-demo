<?php

namespace App\Http\Controllers;

use App\Models\Amigo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AmigoController extends Controller
{
    /**
     * Construtor - Garante que o usuário esteja autenticado
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Exibe a página principal de amizades
     */
    public function index()
    {
        $user = Auth::user();
        $friends = $user->friends();
        $pendingRequests = $user->pendingFriendRequests();
        
        // Usuários que ainda não são amigos e não têm convites pendentes
        $potentialFriends = User::where('id', '!=', $user->id)
            ->whereNotIn('id', $friends->pluck('id'))
            ->whereNotIn('id', $pendingRequests->pluck('user.id'))
            ->get();
        
        return view('amigos.index', compact('friends', 'pendingRequests', 'potentialFriends'));
    }
    
    /**
     * Envia um convite de amizade
     */
    public function enviarConvite(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id'
        ]);
        
        // Verifica se já existe um convite
        $existingRequest = Amigo::where(function($query) use ($request) {
                $query->where('user_id', Auth::id())
                      ->where('friend_id', $request->friend_id);
            })
            ->orWhere(function($query) use ($request) {
                $query->where('user_id', $request->friend_id)
                      ->where('friend_id', Auth::id());
            })
            ->first();
            
        if ($existingRequest) {
            return redirect()->back()->with('error', 'Já existe um convite de amizade entre vocês.');
        }
        
        Amigo::create([
            'user_id' => Auth::id(),
            'friend_id' => $request->friend_id,
            'status' => 'pending'
        ]);
        
        return redirect()->back()->with('success', 'Convite de amizade enviado com sucesso!');
    }
    
    /**
     * Aceita um convite de amizade
     */
    public function aceitarConvite($id)
    {
        $convite = Amigo::findOrFail($id);
        
        // Verifica se o usuário logado é o destinatário do convite
        if ($convite->friend_id != Auth::id()) {
            return redirect()->back()->with('error', 'Você não tem permissão para aceitar este convite.');
        }
        
        $convite->status = 'accepted';
        $convite->save();
        
        return redirect()->back()->with('success', 'Convite de amizade aceito com sucesso!');
    }
    
    /**
     * Rejeita um convite de amizade
     */
    public function rejeitarConvite($id)
    {
        $convite = Amigo::findOrFail($id);
        
        // Verifica se o usuário logado é o destinatário do convite
        if ($convite->friend_id != Auth::id()) {
            return redirect()->back()->with('error', 'Você não tem permissão para rejeitar este convite.');
        }
        
        $convite->status = 'rejected';
        $convite->save();
        
        return redirect()->back()->with('success', 'Convite de amizade rejeitado.');
    }
    
    /**
     * Remove uma amizade
     */
    public function removerAmizade($id)
    {
        $amizade = Amigo::where(function($query) use ($id) {
                $query->where('user_id', Auth::id())
                      ->where('friend_id', $id);
            })
            ->orWhere(function($query) use ($id) {
                $query->where('user_id', $id)
                      ->where('friend_id', Auth::id());
            })
            ->where('status', 'accepted')
            ->firstOrFail();
            
        $amizade->delete();
        
        return redirect()->back()->with('success', 'Amizade removida com sucesso.');
    }
}
