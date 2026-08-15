<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('ADM', function ($user) {
            return $user->role_id == 'ADM';
        });

        Gate::define('FAS', function ($user) {
            return $user->role_id == 'FAS';
        });

        Gate::define('PAR', function ($user) {
            return $user->role_id == 'PAR';
        });
    }
}
