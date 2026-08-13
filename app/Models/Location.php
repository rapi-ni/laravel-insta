<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name'];

    # To count how many posts does the location have (ADMIN SIDE)
    public function posts(){
        
        return $this->hasMany(Post::class);
    }
}
