<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'spicy_level' => 'integer',
            'sweet_level' => 'integer',
            'meat_level' => 'integer',
            'vegetable_level' => 'integer',
        ];
    }

    # To get the posts of a user
    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    # To get the follower of a user
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    # To get all the  user that the user is following
    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    # Returns TRUE if AUTH USER already followed the user
    public function isFollowed()
    {
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
    }

    # To get the liked posts
    public function likedposts()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->latest();
    }

    # To get the commented post 
    public function commentedPosts()
    {
        return $this->belongsToMany(Post::class, 'comments', 'user_id', 'post_id')
            ->withTimestamps();
    }

    public function conversationsAsUserOne()
    {
        return $this->hasMany(Conversation::class, 'user_one_id');
    }

    public function conversationsAsUserTwo()
    {
        return $this->hasMany(Conversation::class, 'user_two_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

}
