<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $guarded = ['id'];

    // Relationships
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user1()
    {
        return $this->belongsTo(User::class);
    }

    public function user2()
    {
        return $this->belongsTo(User::class);
    }
}
