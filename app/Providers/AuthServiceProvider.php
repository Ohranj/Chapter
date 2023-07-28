<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Services\CustomGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::extend('CustomGuard', function($app, $name, array $config) {
            return new CustomGuard(
                Auth::createUserProvider($config['provider']), $name, $app['session.store']
            );
        });
    }
}
