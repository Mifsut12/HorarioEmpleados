<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\empleado;
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
        Gate::define('acceder-admin' , function(empleado $empleado){
            return $empleado->rol === 'admin';
        });


        Gate::define('acceder-super-admin' , function(empleado $empleado){
            return $empleado->rol === 'super-Admin';
        });
    }
}
