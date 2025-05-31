<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumTopic;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = ForumTopic::with('user')
            ->withCount('posts')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('forum.index', compact('topics'));
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
    public function storeTopic(Request $request)
    {
        abort_unless(Auth::check(), 403);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $topic = ForumTopic::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
        ]);
        ForumPost::create([
            'topic_id' => $topic->id,
            'user_id' => Auth::id(),
            'text' => $data['content'],
        ]);
        return redirect('/forum')->with('success', 'Topic created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $topic = ForumTopic::with('user')->findOrFail($id);
        $posts = ForumPost::with('user')
            ->where('topic_id', $id)
            ->orderBy('created_at', 'asc')
            ->paginate(5);
        return view('forum.show', compact('topic', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storePost(Request $request)
    {
        abort_unless(Auth::check(), 403);
        $data = $request->validate([
            'topic_id' => 'required|integer|exists:forum_topics,id',
            'content' => 'required|string',
        ]);
        ForumPost::create([
            'topic_id' => $data['topic_id'],
            'user_id' => Auth::id(),
            'text' => $data['content'],
        ]);
        return redirect("/forum/topic/{$data['topic_id']}");
    }

    public function __construct()
    {
        $this->middleware('auth')->only(['storeTopic', 'storePost']);
    }
}
