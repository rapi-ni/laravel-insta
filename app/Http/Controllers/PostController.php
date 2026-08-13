<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PostImage;
use App\Models\Location;

class PostController extends Controller
{
    private $post;
    private $category;
    private $location;
    
    public function __construct(Post $post, Category $category, Location $location)
    {
        $this->post     = $post;
        $this->category = $category;
        $this->location = $location;
    }

    #create post page(relative all categories)
    public function create() {
        $all_categories     = $this->category->all();
        $all_locations      = $this->location->all(); 

        return view('users.posts.create')
                                ->with('all_categories', $all_categories)
                                ->with('all_locations', $all_locations);
    }

    #insert date to datebase(post and pivot table)
    public function store(Request $request){
        #1. Validate all form date
        $request ->validate([
            'category_id'   => 'required|exists:categories,id',
            'location_name' => 'required|min:1|max:255',
            'description'   => 'required|min:1|max:1000',
            'rating_taste'  => 'required|numeric|between:0.5,5.0',
            'rating_volume' => 'required|numeric|between:0.5,5.0',
            'rating_sulit'  => 'required|numeric|between:0.5,5.0',
            'rating_vibes'  => 'required|numeric|between:0.5,5.0',
            'images'        => 'required|array|max:5',
            'images.*'      => 'image|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        #2. Save the post
        $this->post->user_id        = Auth::user()->id;
        if ($request->hasFile('images')) {
            $first_image = $request->file('images')[0];
            $this->post->image = 'data:image/' . $first_image->extension() . ';base64,' . base64_encode(file_get_contents($first_image));
        }
        $this->post->description   = $request->description;

        if ($request->filled('location_id')) {
            $this->post->location_id = $request->location_id;
        } else {
            $new_location = \App\Models\Location::firstOrCreate([
                'name' => $request->location_name
            ]);
            $this->post->location_id = $new_location->id;
        }

        $this->post->rating_taste  = $request->rating_taste;
        $this->post->rating_volume = $request->rating_volume;
        $this->post->rating_sulit  = $request->rating_sulit;
        $this->post->rating_vibes  = $request->rating_vibes;
        $this->post->user_id       = Auth::user()->id;
        $this->post->save();

        #3. Save the single category in the category_post table
        $this->post->categorypost()->create([
            'category_id' => $request->category_id
        ]);

        #4. Save images (if user put more than 2 images)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $base64_image = 'data:image/' . $file->extension() . ';base64,' . base64_encode(file_get_contents($file));

                $post_image = new PostImage;
                $post_image->post_id = $this->post->id;
                $post_image->image   = $base64_image;
                $post_image->save();
            }
        }
        
        #5. Go back to homepage
        return redirect()->route('index');
    }

    #show post page
    public function show($id){
        $post = $this->post->with(['images', 'location'])->findOrFail($id);
        return view('users.posts.show')->with('post', $post);
    }

    #edit specific post
    public function edit($id){
        $post = $this->post->findOrFail($id);
        
        #If the Auth user is NOT the owner, redirect to homepage
        if(Auth::user()->id != $post->user_id){
            return redirect()->route('index');
        }

        # get all the categories and locations to  display in edit page
        $all_categorires = $this->category->all();
        $all_locations   = $this->location->all(); 

        # get all the category IDs of the post. Save in an array
        $selected_categories = [];
        foreach($post->categorypost as $categorypost){
            $selected_categories[] = $categorypost->category_id;
        }

        return view('users.posts.edit')->with('post', $post)
                                        ->with('all_categories', $all_categorires)
                                        ->with('all_locations', $all_locations)
                                        ->with('selected_categories', $selected_categories);
    }

    #update specific post
    public function update(Request $request, $id){
        #1. Validate all form date
        $request ->validate([
            'category_id'   => 'required|exists:categories,id',
            'location_id'   => 'required|exists:locations,id',
            'description'   => 'required|min:1|max:1000',
            'rating_taste'  => 'required|numeric|between:0.5,5.0',
            'rating_volume' => 'required|numeric|between:0.5,5.0',
            'rating_sulit'  => 'required|numeric|between:0.5,5.0',
            'rating_vibes'  => 'required|numeric|between:0.5,5.0',
            'image'         => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        #2. Update the post
        $post = $this->post->findOrFail($id);
        $post->description   = $request->description;
        $post->location_id   = $request->location_id;
        $post->rating_taste  = $request->rating_taste;
        $post->rating_volume = $request->rating_volume;
        $post->rating_sulit  = $request->rating_sulit;
        $post->rating_vibes  = $request->rating_vibes;
         
        # if there is a new image...
        if ($request->image) {
            # Update the new image
            $post->image = 'data:image/' . $request->image->extension() .
                              ';base64,' . base64_encode(file_get_contents($request->image));
        } 
        $post->save();

        #3. Update the single category in the category_post table
        $post->categorypost()->delete();
        $post->categorypost()->create([
            'category_id' => $request->category_id
        ]);

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