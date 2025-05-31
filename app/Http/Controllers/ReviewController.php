<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Album;
use Illuminate\Support\Facades\Auth; // Importa o facade Auth

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews, optionally filtered by user.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'album'])->orderBy('created_at', 'desc');
        if ($request->has('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }
        $reviews = $query->get();
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create()
    {
        $albums = Album::all();
        return view('reviews.create', compact('albums'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'album_id' => 'required|integer|exists:albums,id',
            'text' => 'required|string|max:1000',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $data['user_id'] = Auth::id();
        Review::create($data);

        return redirect('/reviews')->with('success', 'Review created successfully.');
    }
}
