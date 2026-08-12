<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    #store comment to datebase
    public function store(Request $request, $post_id){
        $request->validate(
            [
            'comment_body' . $post_id=> 'required|max:150'
        ],
            [
            'comment_body' . $post_id . '.required' => 'You cannot submit an empty comment.',
            'comment_body' . $post_id . '.max'      => 'You comment must not have more than 150 characters.',
        ]
        );

        $this->comment->body = $request->input('comment_body' . $post_id);
        //input() - retrieves the value of an input field from the form request
        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;

        // For replies, parent_id is included.
        $this->comment->parent_id = $request->input('parent_id');

        $this->comment->save();

        return redirect()->route('post.show', $post_id);
    }

    #delete comment from datebase
    public function destroy($id){
        $comment = $this->comment->findOrFail($id);
        $comment->delete();

        return redirect()->back();
    }
}
