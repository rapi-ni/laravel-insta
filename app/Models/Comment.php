<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    #To get the owner of the comment
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }
    
    #To get the parent Comment
    public function parent(){
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    #To get replies
    public function replies(){
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'comment_id');
    }

    public function isLiked()
    {
        return $this->likes()
            ->where('user_id', Auth::user()->id)
            ->exists();
    }
}
