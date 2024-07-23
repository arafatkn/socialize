<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Chat;
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
        $chat = Chat::where('user1_id', min($user->id, auth()->id()))->where('user2_id', max($user->id, auth()->id()))->first();

        return Inertia::render('Profile/Show', ['userData' => $user, 'chat' => $chat, 'posts' => PostResource::collection($posts)]);
    }
}
