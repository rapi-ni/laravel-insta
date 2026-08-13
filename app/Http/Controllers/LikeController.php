<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like){
        $this->like = $like;
    }

    // Post Like

    # store date for likes
    public function store($post_id) {

       // exsit like -> not add
       $existingLike = $this->like
        ->where('user_id', Auth::user()->id)
        ->where('post_id', $post_id)
        ->whereNull('comment_id')
        ->first();
        
       if(!$existingLike){ 
        $like = new Like();
        $like->user_id = Auth::user()->id;
        $like->post_id = $post_id;
        $like->comment_id = null;
        $like->save();
       }

       return response()->json([
          'message' => 'Add the like'
       ]);
    }
    
    # Delete post Like
    public function destroy($post_id) { 
        $this->like
           ->where('user_id', Auth::user()->id) 
           ->where('post_id', $post_id) 
           ->whereNull('comment_id')
           ->delete();

        return response()->json([
            'message'=> 'Remove the like'
        ]);
    }

    // Comment / Reply Like 

    #Store comment like
    public function commentStore($comment_id){
        // check exist like 
        $existingLike = $this->like
           ->where('user_id', Auth::user()->id) 
           ->where('comment_id', $comment_id)   
           ->first();

        if(!$existingLike){
            $like = new Like();

            $like->user_id = Auth::user()->id;
            $like->post_id = null;
            $like->comment_id = $comment_id;

            $like->save();
        }

        return response()->json([
            'message'=> 'Comment add the like'
        ]);
    }

    #Delete comment like 
    public function commentDestroy($comment_id){
        $this->like
           ->where('user_id', Auth::user()->id)
           ->where('comment_id', $comment_id)
           ->delete();

        return response()->json([
            'message'=> 'Comment remove the like'
        ]);
    }
}
