<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
