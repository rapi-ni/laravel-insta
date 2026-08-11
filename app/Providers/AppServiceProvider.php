<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
//gate - determines if a user is authorized to perform a given action 
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        //create admin gete
        Gate::define('admin', function($user){
            return $user->role_id === User::ADMIN_ROLE_ID;
            //$user - id an instance of the User Model
        });
    }
}
