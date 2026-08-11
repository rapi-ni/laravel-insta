<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(){
        $all_users = $this->user->withTrashed()->latest()->paginate(5); // retrieve all users
        // paginate() - limit the result based on the current page
        // withTrashed() - include the soft deleted data in query's result
        return view('admin.users.index')->with('all_users', $all_users);
    }

    # deactivate a user
    public function deactivate($id){
        $this->user->destroy($id);
        return redirect()->back();        
    }

    # activate a user
    public function activate($id){
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        // onlyTrashed() - ritrieves soft deleted date/users only
        // restore() - thieswill "undelete" soft deleted data. This will set the deleted_at column to NULL;
        return redirect()->back(); 
    }
}
