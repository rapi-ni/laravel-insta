<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;       
    }

    # show profile page
    public function show($id){
        $user = $this->user->findOrFail($id);
        $liked_posts = $user->likedPosts()->latest()->get();

        return view('users.profile.show')
                    ->with('user', $user)
                    ->with('liked_posts', $liked_posts);
    }
        

    # edit auth user's profile page
    public function edit(){
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    # update auth user's profile page
    public function update(Request $request){
        # varilate all form date
        $request->validate([
            'name'          => 'required|min:1|max:50',
            'email'         => 'required|email|max:255|unique:users,email,' . Auth::user()->id,
            'introduction'  => 'nullable|max:100',
            'avatar'        => 'nullable|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        $user               = $this->user->findOrFail(Auth::user()->id);
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->introduction = $request->introduction;

        # if the user update an avatar
        if ($request->avatar) {
            # Update the new avatar
            $user->avatar = 'data:image/' . $request->avatar->extension() .
                              ';base64,' . base64_encode(file_get_contents($request->avatar));
        } 
        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);
    }

    # open followers page
    public function followers($id){
        $user = $this->user->findOrFail($id);
        return view('users.profile.followers')->with('user', $user);
    }

    # open following page
    public function following($id){
        $user = $this->user->findOrFail($id);
        return view('users.profile.following')->with('user', $user);
    }
}
