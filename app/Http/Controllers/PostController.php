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
            'content' => 'bail|required_without:files',
            'files' => 'bail|required_without:content|array',
            'files.*' => 'bail|nullable|file|mimetypes:image/*,audio/*,video/*|max:102400',
        ]);

        if ($request->file('files')) {
            $files = [];

            foreach ($request->file('files') as $file) {
                $path = $file->storeAs('posts', strtolower(Str::ulid()).'.' . $file->extension(), 'public');
                $files[] = ['path' => $path, 'size' => $file->getSize(), 'extension' => $file->extension(), 'mime' => $file->getMimeType()];
            }
        }

        $post = new Post([
            'content' => $request->input('content', '') ?? '',
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
