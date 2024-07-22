<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->get();

        return Inertia::render('Posts/Index', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        return Inertia::render('Posts/Single', ['post' => $post]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'bail|required',
        ]);

        $post = new Post([
            'content' => $request->input('content'),
        ]);
        $post->user_id = auth()->id();

        if ($post->save()) {
            return back()->with('success', 'Posted successfully');
        }

        return back()->with('error', 'Unable to post');
    }
}
