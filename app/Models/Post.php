<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'user_id'];

    protected $casts = ['files' => 'json'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
