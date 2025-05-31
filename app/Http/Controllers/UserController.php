<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // Add this import

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
        return view('users.profile', compact('user'));
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
}