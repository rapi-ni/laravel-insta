<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    private $post;

    public function __construct(post $post){
        $this->post = $post;
    }

    public function index(){
        $all_posts = $this->post->withTrashed()->latest()->paginate(5); // retrieve all posts
        // paginate() - limit the result based on the current page
        // withTrashed() - include the soft deleted data in query's result
        return view('admin.posts.index')->with('all_posts', $all_posts);
    }

    # hide a post
    public function hide($id){
        $this->post->destroy($id);
        return redirect()->back();        
    }

    # unhide a post
    public function unhide($id){
        $this->post->onlyTrashed()->findOrFail($id)->restore();
        // onlyTrashed() - ritrieves soft deleted date/posts only
        // restore() - thieswill "undelete" soft deleted data. This will set the deleted_at column to NULL;
        return redirect()->back(); 
    }
}

