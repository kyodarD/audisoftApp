<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //$this->registerPolicies();

        Gate::before(function ($user, $ability) {
			//return $user->hasRole('Administrador') ? true : null;
            return $user->hasVerifiedEmail() ? true : null;
        });
    }
}
