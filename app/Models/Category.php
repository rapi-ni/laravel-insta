<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    # To count how many posts does the category have (ADMIN SIDE)
    public function categorypost(){
        return $this->hasMany(CategoryPost::class);
    }
}
