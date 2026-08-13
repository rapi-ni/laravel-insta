<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//yuki comment
// miki edit here
// manatsu edit here

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/people', [HomeController::class, 'search'])->name('search');

    Route::group([ 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
        //USER
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');

        //POST
        Route::get('/posts', [PostsController::class, 'index'])->name('posts');
        Route::delete('/posts/{id}/hide', [PostsController::class, 'hide'])->name('posts.hide');
        Route::patch('/posts/{id}/unhide', [PostsController::class, 'unhide'])->name('posts.unhide');

        //CATEGORY
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
        Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{id}/update', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('categories/{id}/delete', [CategoriesController::class, 'destroy'])->name('categories.destroy');
        

    });
    
    #POST
    Route::group([ 'prefix' => 'post', 'as' => 'post.'], function(){
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/show', [PostController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [PostController::class, 'destroy'])->name('destroy');
    });

    #COMMENT
    Route::group([ 'prefix' => 'comment', 'as' => 'comment.'], function(){
        Route::post('/{post_id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/{post_id}/delete', [CommentController::class, 'destroy'])->name('destroy');
    });

    #PROFILE
    Route::group([ 'prefix' => 'profile', 'as' => 'profile.'], function(){
        Route::get('/{id}/show', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/{id}/followers', [ProfileController::class, 'followers'])->name('followers');
        Route::get('/{id}/following', [ProfileController::class, 'following'])->name('following');
    });

    #LIKE
    Route::group([ 'prefix' => 'like', 'as' => 'like.'], function(){
        // Post Like
        Route::post('/{post_id}/store', [LikeController::class, 'store'])
            ->name('store');
        Route::delete('/{post_id}/destroy', [LikeController::class, 'destroy'])
            ->name('destroy');
        //  Comment / Reply Like
        Route::post('/comment/{comment_id}/like', [LikeController::class, 'commentStore'])
            ->name('comment.store');
        Route::delete('/comment/{comment_id}/like', [LikeController::class, 'commentDestroy'])
            ->name('comment.destroy');
    });

    #FOLLOW
    Route::group([ 'prefix' => 'follow', 'as' => 'follow.'], function(){
        Route::post('/{user_id}/store', [FollowController::class, 'store'])->name('store');
        Route::delete('/{user_id}/destroy', [FollowController::class, 'destroy'])->name('destroy');
    });

    #FOLLOWING
    Route::group([ 'prefix' => 'following', 'as' => 'following.'], function(){
        Route::post('/{user_id}/store', [FollowController::class, 'store'])->name('store');
        Route::delete('/{user_id}/destroy', [FollowController::class, 'destroy'])->name('destroy');
    });

    #MESSAGES
    Route::group(['prefix' => 'messages', 'as' => 'messages.'], function(){
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::post('/start/{user}', [MessageController::class, 'start'])->name('start');
        Route::get('/{conversation}', [MessageController::class, 'show'])->name('show');
        Route::post('/{conversation}', [MessageController::class, 'store'])->name('store');
        Route::delete('/message/{message}', [MessageController::class, 'destroy'])->name('destroy');
    });
    
 });