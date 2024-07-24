<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function store(Chat $chat, Request $request)
    {
        $sender_id = auth()->id();
        abort_if($chat->user1_id !== $sender_id && $chat->user2_id !== $sender_id, 403);

        $request->validate([
            'content' => 'bail|required_without:files',
            'files' => 'bail|required_without:content|array',
            'files.*' => 'bail|nullable|file|mimetypes:image/*,audio/*,video/*|max:102400',
        ]);

        if ($request->file('files')) {
            $files = [];

            foreach ($request->file('files') as $file) {
                $path = $file->storeAs('chats/'.md5($chat->id), Str::slug(Str::beforeLast($file->getClientOriginalName(), '.')).'_'.strtolower(Str::ulid()).'.' . $file->extension(), 'public');
                $files[] = ['path' => $path, 'size' => $file->getSize(), 'extension' => $file->extension(), 'mime' => $file->getMimeType()];
            }
        }

        $message = new Message();
        $message->chat_id = $chat->id;
        $message->sender_id = $sender_id;
        $message->content = $request->input('content');
        $message->files = $files ?? null;

        if ($message->save()) {
            if ($sender_id === $chat->user1_id) {
                $chat->user2_unread_count += 1;
            } else {
                $chat->user1_unread_count += 1;
            }
            $chat->save();

            return back()->with('success', 'Sent successfully');
        }

        return back()->with('error', 'Unable to send');
    }
}
