<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $posts = Post::query()->with('user')->latest('id')->cursorPaginate(50);

        return Inertia::render('Index', ['posts' => PostResource::collection($posts)]);
    }

    public function show($slug)
    {
        return Inertia::render('Single');
    }
}
