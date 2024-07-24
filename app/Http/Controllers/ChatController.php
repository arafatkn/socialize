<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $chat = Chat::where('user1_id', $user_id)
            ->orWhere('user2_id', $user_id)
            ->latest('updated_at')->firstOrFail();

        return redirect()->route('chats.show', $chat->id);
    }

    public function show(Chat $chat)
    {
        $user_id = auth()->id();
        abort_if($chat->user1_id !== $user_id && $chat->user2_id !== $user_id, 403);

        $messages = $chat->messages()->with(['sender'])->latest('id')->cursorPaginate(200);

        if ($user_id === $chat->user1_id) {
            $chat->user1_unread_count = 0;
        } else {
            $chat->user2_unread_count = 0;
        }

        $chat->save();

        $chat->load(['user1', 'user2']);

        $chats = Chat::where('user1_id', $user_id)
            ->orWhere('user2_id', $user_id)
            ->with(['user1', 'user2'])
            ->latest('updated_at')->get();

        return Inertia::render('Chats/Show', [
            'messages' => MessageResource::collection($messages),
            'chat' => $chat,
            'chats' => $chats,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'bail|required|integer|exists:users,id',
            'content' => 'bail|required',
        ]);

        $sender_id = auth()->id();
        $receiver_id = $request->receiver_id;

        $user1_id = min([$receiver_id, $sender_id]);
        $user2_id = max([$receiver_id, $sender_id]);

        $chat = Chat::where(['user1_id' => $user1_id, 'user2_id' => $user2_id])->first();

        if (!$chat) {
            $chat = Chat::create(['user1_id' => $user1_id, 'user2_id' => $user2_id, 'user1_unread_count' => 1, 'user2_unread_count' => 1]);
        } else {
            $chat->user1_unread_count += 1;
            $chat->user2_unread_count += 1;
            $chat->save();
        }

        $message = new Message();
        $message->chat_id = $chat->id;
        $message->sender_id = $sender_id;
        $message->content = $request->input('content');
        $message->save();

        return redirect()->route('chats.show', $chat->id)->with('success', 'Chat started successfully');
    }
}
