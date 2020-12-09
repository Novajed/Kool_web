<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use App\Organization;
use App\Observers\OrganizationObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GuardResolver::class, function () {
            return GuardResolver();
        });

        if ($this->app->environment() != 'testing') {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //If user belongs to an organization
        Blade::if('bto', function () {
            return auth()->user() && auth()->user()->belongsToOrganization();
        });

        //If user is student or individual
        Blade::if('user',function(){
            return auth()->user() && auth()->user()->isUser();
        });

        Organization::observe(OrganizationObserver::class);

    }
}
