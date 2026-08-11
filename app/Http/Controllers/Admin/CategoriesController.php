<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
     private $category;

    public function __construct(category $category){
        $this->category = $category;
    }

    public function index(){
        $all_categories = $this->category->withCount('categorypost')->latest()->get();
        $uncategorized_count = Post::doesntHave('categorypost')->count();

        return view('admin.categories.index')->with('all_categories', $all_categories)
                                            ->with('uncategorized_count', $uncategorized_count);

    }

    public function store(Request $request){
        $request ->validate([
            'category'      => 'required|unique:categories,name'
        ]);

        $this->category->name = $request->category;
        $this->category->save();

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $request ->validate([
            'category'      => 'required|unique:categories,name,' . $id
        ]);

        $category = $this->category->findOrFail($id);
        $category->name    = $request->category;
        $category->save();

        return redirect()->back();    
    }

    public function destroy($id)
    {
        $category = $this->category->findOrFail($id);
        $category->delete();

        return redirect()->back();
    }

}
