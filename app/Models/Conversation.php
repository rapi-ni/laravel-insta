<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'user_one_id',
        'user_two_id',
    ];

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id')
            ->withTrashed();
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id')
            ->withTrashed();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function hasParticipant(int $userId): bool
    {
        return $this->user_one_id === $userId
            || $this->user_two_id === $userId;
    }

    public function otherUser(int $currentUserId): User
    {
        return $this->user_one_id === $currentUserId
            ? $this->userTwo
            : $this->userOne;
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)
            ->latestOfMany();
    }

    public function index()
    {
        $conversations = Conversation::with([
            'userOne',
            'userTwo',
            'latestMessage',
        ])
            ->whereHas('messages')
            ->where(function ($query) {
                $query->where('user_one_id', Auth::id())
                    ->orWhere('user_two_id', Auth::id());
            })
            ->latest('updated_at')
            ->get();

        return view(
            'users.messages.index',
            compact('conversations')
        );
    }
}