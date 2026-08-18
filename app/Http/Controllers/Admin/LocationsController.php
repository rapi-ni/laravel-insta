<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Post;

class LocationsController extends Controller
{
    private $location;
    private $post;

    public function __construct(Location $location, Post $post){
        $this->location = $location;
        $this->post     = $post;
    }

    public function index(){
        $all_locations = $this->location->withCount('posts')->latest()->get();
        $no_location_count = $this->post->doesntHave('location')->count();

        return view('admin.locations.index')
            ->with('all_locations', $all_locations)
            ->with('no_location_count', $no_location_count);
    }

    public function store(Request $request){
        $request->validate([
            'location_name' => 'required|min:1|max:255|unique:locations,name',
        ]);

        $this->location->create([
            'name' => trim($request->location_name)
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $request->validate([
            'location_name' => 'required|min:1|max:255|unique:locations,name,' . $id
        ]);

        $location = $this->location->findOrFail($id);
        
        $location->name = trim($request->location_name);
        $location->save();

        return redirect()->back();    
    }

    public function destroy($id){
        $location = $this->location->findOrFail($id);
        $location->delete();

        return redirect()->back();
    }




}
