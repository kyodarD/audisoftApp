<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gate global para super-admin
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }

            // Si existe un permiso 'gestionar {recurso}', autorizar acciones derivadas
                    return null; // Sigue con la validación normal si no aplica
        });
    }
}
