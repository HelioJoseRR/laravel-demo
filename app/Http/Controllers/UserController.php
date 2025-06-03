<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Amigo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // Example data for highlights
        $highlights = [
            [
                'image' => 'https://placehold.co/100',
                'title' => 'Popular lists',
                'description' => 'Discover the most popular lists curated by music lovers.',
                'user_avatar' => 'https://placehold.co/24',
                'username' => 'SushiRollSama',
            ],
            [
                'image' => 'https://placehold.co/100',
                'title' => 'Trending new albums',
                'description' => 'Stay updated with the latest trending albums in the music scene.',
                'user_avatar' => 'https://placehold.co/24',
                'username' => 'OBackendNemVaiDarTrabalhoHein',
            ],
        ];

        // Example data for events
        $events = [
            [
                'image' => 'https://placehold.co/300',
                'title' => 'RockMassayó 2025',
                'date' => '15 Mar 2025',
            ],
            [
                'image' => 'https://placehold.co/300',
                'title' => 'Jazzghost',
                'date' => '22 Apr 2025',
            ],
            [
                'image' => 'https://placehold.co/300',
                'title' => 'Indie Stuff Nobody Cares',
                'date' => '30 May 2025',
            ],
        ];

        // Example data for user-curated lists
        $lists = [
            [
                'image' => 'https://placehold.co/100',
                'title' => 'Top 10 Grunge Songs!!1',
                'username' => 'CurtKobayashi',
            ],
            [
                'image' => 'https://placehold.co/100',
                'title' => 'Breganejo 2020',
                'username' => 'JucimeireDantas22',
            ],
            [
                'image' => 'https://placehold.co/100',
                'title' => 'Deep House songs',
                'username' => 'johndoe',
            ],
            [
                'image' => 'https://placehold.co/100',
                'title' => 'As melhores dos 80',
                'username' => 'zejument',
            ],
        ];

        // Example data for forum discussions
        $discussions = [
            [
                'id' => 1,
                'title' => 'Best guitar solos of all time',
                'user_id' => 1,
                'username' => 'Guitar_Hero_99',
                'replies' => 42,
            ],
            [
                'id' => 2,
                'title' => 'I know it\'s unrelated but my TV just broke',
                'user_id' => 2,
                'username' => 'JuanRodrigues',
                'replies' => 18,
            ],
            [
                'id' => 3,
                'title' => 'How to produce lo-fi beats?',
                'user_id' => 3,
                'username' => 'LoFiLover',
                'replies' => 27,
            ],
        ];

        return view('users.index', compact('users', 'highlights', 'events', 'lists', 'discussions'));
    }

    public function register()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registration successful! You can now log in.');
    }

    public function profile($id)
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

    public function login()
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/');
        }
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }

    // ===== MÉTODOS DE AMIZADE =====
    
    /**
     * Exibe a página principal de amizades
     */
    public function amigos()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $user = Auth::user();
        $friends = $user->friends();
        $pendingRequests = $user->pendingFriendRequests();
        
        // Usuários que ainda não são amigos e não têm convites pendentes
        $friendIds = $friends->pluck('id')->toArray();
        $pendingIds = $pendingRequests->pluck('user.id')->toArray();
        
        // Também excluir convites que o usuário atual enviou
        $sentRequestIds = $user->sentFriendRequests()
            ->where('status', 'pending')
            ->pluck('friend_id')
            ->toArray();
        
        $excludeIds = array_merge($friendIds, $pendingIds, $sentRequestIds, [Auth::id()]);
        
        $potentialFriends = User::whereNotIn('id', $excludeIds)->get();
        
        return view('users.amigos', compact('friends', 'pendingRequests', 'potentialFriends'));
    }
    
    /**
     * Envia um convite de amizade
     */
    public function enviarConvite(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
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
        if (!Auth::check()) {
            return redirect('/login');
        }
        
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
        if (!Auth::check()) {
            return redirect('/login');
        }
        
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
        if (!Auth::check()) {
            return redirect('/login');
        }
        
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
