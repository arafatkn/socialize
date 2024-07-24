<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => strip_tags($this->content),
            'pinned' => $this->pinned,
            'created_at' => $this->created_at,
            'created_ago' => $this->created_at->diffForHumans(),
            'is_new' => $this->created_at->diffInSeconds() < 15,
            'files' => $this->files && is_array($this->files) ? \Arr::map($this->files, fn ($file) => (['path' => \Storage::url($file['path']), 'mime' => $file['mime'] ?? '', 'size' => $file['size'] ?? ''])) : $this->files,
            'sender' => $this->sender,
            'chat_id' => $this->chat_id,
        ];
    }
}
