<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        # get all posts
        // $all_posts  = $this->post->latest()->get();
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();
        return view('users.home')
                ->with('home_posts', $home_posts)
                ->with('suggested_users', $suggested_users);
    }

    # Get the post of the users that the AUTH USER is following
    public function getHomePosts(){
        $all_posts = $this->post->latest()->get(); // get all posts
        $home_posts = []; // array for the filtered posts

        foreach($all_posts as $post){ // loop through allt the posts
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id){
                // if the USER is followed by AUTH USER
                // OR the post's owner is the AUTH USER's
                $home_posts[] = $post; // if condiitons are TRUE put the data inside array
            }
        }
        return $home_posts; // return array
    }

    # Get the USERS that the AUTH USER is NOT following
    public function getSuggestedUsers(){
        $all_users = $this->user->all()->except(Auth::user()->id); // get all users expect LOGGED IN USER
        $suggested_users = []; // array for the suggested users

        foreach($all_users as $user){ // loop through all users
            if(!$user->isFollowed()){
                //if the user is NOT being followed by AUTH USER
                $suggested_users[] = $user;
            }
        }
        return $suggested_users;// return array
    }

    public function search(Request $request){
        $users = $this->user->where('name', 'like', '%' .$request->search. '%')->get();
        return view('users.search')->with('users', $users)->with('search', $request->search);
    }
}
