<?php

namespace App\Providers;

use App\Eloquent\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->grantAllPermissionToSuperAdmin();
        $this->registeObservers();
    }

    private function grantAllPermissionToSuperAdmin()
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin');
        });
    }

    private function registeObservers()
    {
        User::observe(\App\Observers\UserObserver::class);
    }
}
