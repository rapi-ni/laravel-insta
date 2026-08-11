<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, SoftDeletes; // 

    #To get the owner of the post
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    #To get the categories under a post
    public function categorypost(){
        return $this->hasMany(CategoryPost::class);
    }

    #To get the comments of a post
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    # To get the likes of a post
    public function likes(){
        return $this->hasMany(Like::class);
    }

    # Returns TRUE if the AUTH USER alredy liked the post
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        //retrieve all likes of a post buy calling $this->likes()
        //use WHERE clause for FILTER OUT the date
        //check user_id colomn if AUTH's ID exists
    }
}
