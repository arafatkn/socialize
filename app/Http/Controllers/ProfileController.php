<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::query()->get();

        return Inertia::render('Profile/Index', ['users' => $users]);
    }

    public function show($slug)
    {
        if (Str::contains($slug, '@')) {
            $user = User::where('email', $slug)->firstOrFail();
            return redirect()->route('profile.show', $user->username);
        }  else {
            $user = User::where('username', $slug)->firstOrFail();
        }

        $posts = $user->posts()->latest('id')->cursorPaginate(30);

        return Inertia::render('Profile/Show', ['userData' => $user, 'posts' => PostResource::collection($posts)]);
    }
}
