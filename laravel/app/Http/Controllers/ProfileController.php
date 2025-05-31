<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $reviews = Review::with('album')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $friends = User::where('id', '!=', $id)->take(5)->get();
        return view('users.profile', compact('user', 'reviews', 'friends'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_unless(Auth::id() == (int)$id, 403);
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_unless(Auth::id() == (int)$id, 403);
        $data = $request->validate([
            'email' => 'required|email',
            'bio' => 'nullable|string',
        ]);
        $user = User::findOrFail($id);
        $user->update($data);
        return redirect("/profile/{$id}")->with('success', 'Profile updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
