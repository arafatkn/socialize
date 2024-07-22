<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            'files' => 'nullable|array',
            'files.*' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        if ($request->file('files')) {
            $files = [];

            foreach ($request->file('files') as $file) {
                $path = $file->storeAs('posts', strtolower(Str::ulid()).'.' . $file->extension(), 'public');
                $files[] = ['path' => $path];
            }
        }

        $post = new Post([
            'content' => $request->input('content'),
        ]);
        $post->user_id = auth()->id();
        if (isset($files)) {
            $post->files = $files;
        }

        if ($post->save()) {
            return back()->with('success', 'Posted successfully');
        }

        return back()->with('error', 'Unable to post');
    }
}
