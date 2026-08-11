<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostController extends Controller
{
    private $post;
    private $category;
    
    public function __construct(Post $post, Category $category)
    {
        $this->post     = $post;
        $this->category = $category;
    }

    #create post page(relative all categories)
    public function create() {
        $all_categories     = $this->category->all();
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    #insert date to datebase(post and pivot table)
    public function store(Request $request){
        #1. Validate all form date
        $request ->validate([
            'category'      => 'required|array|between:1,3',
            'description'   => 'required|min:1|max:1000',
            'image'         => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        #2. Save the post
        $this->post->user_id        = Auth::user()->id;
        $this->post->image          = 'data:image/' . $request->image->extension() .
                                      ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description    = $request->description;
        $this->post->save();

        #3. Save the category in the category_post table
        foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }
        $this->post->categorypost()->createMany($category_post);

        #4. Go back to homepage
        return redirect()->route('index');
    }

    #show post page
    public function show($id){
        $post = $this->post->findOrFail($id);
        return view('users.posts.show')->with('post', $post);
    }

    #edit specific post
    public function edit($id){
        $post = $this->post->findOrFail($id);
        
        #If the Auth user is NOT the owner, redirect to homepage
        if(Auth::user()->id != $post->user_id){
            return redirect()->route('index');
        }

        # get all the  categories to  display in edit page
        $all_categorires = $this->category->all();

        # get all the category IDs of the post. Save in an array
        $selected_categories = [];
        foreach($post->categorypost as $categorypost){
            $selected_categories[] = $categorypost->category_id;
        }

        return view('users.posts.edit')->with('post', $post)
                                        ->with('all_categories', $all_categorires)
                                        ->with('selected_categories', $selected_categories);
    }

    #update specific post
    public function update(Request $request, $id){
        #1. Validate all form date
        $request ->validate([
            'category'      => 'required|array|between:1,3',
            'description'   => 'required|min:1|max:1000',
            'image'         => 'nullable|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        #2. Update the post
        $post = $this->post->findOrFail($id);
        $post->description    = $request->description;
         
        # if there is a new image...
        if ($request->image) {
            # Update the new image
            $post->image = 'data:image/' . $request->image->extension() .
                              ';base64,' . base64_encode(file_get_contents($request->image));
        } 
        $post->save();

        #3. Update the category in the category_post table
        $post->categorypost()->delete();
        foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }
        $post->categorypost()->createMany($category_post);

        #4. Go back to homepage
        return redirect()->route('post.show', $id);
    }

    #delete specofic post
    public function destroy($id){
        $post = $this->post->findOrFail($id);       
        #1. Delete the post
        $post->delete();

        #2. Go back to homepage
        return redirect()->route('index');
    }




}