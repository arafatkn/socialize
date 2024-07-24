<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'reference',
    ];

    protected $appends = ['public_profile_url'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'permissions' => 'object',
    ];

    // Custom Attributes
    function getDashboardUrlAttribute(): string
    {
        return '/';
    }

    function getPublicProfileUrlAttribute(): string
    {
        return route('profile.show', $this->username);
    }

    // Scopes
    function scopeEmail($query, string $email)
    {
        return $query->where('email', strtolower($email));
    }

    // Relationships
    function posts()
    {
        return $this->hasMany(Post::class);
    }
}
