<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('mismo_deporte', function ($attribute, $value, $parameters, $validator) {
            $otroCampo = $parameters[0];
            $datos = $validator->getData();
        
            return isset($datos[$otroCampo]) && $value === $datos[$otroCampo];
        });

        Validator::extend('diferentes_equipos', function ($attribute, $value, $parameters, $validator) {
            $otroCampo = $parameters[0];
            $datos = $validator->getData();

            return isset($datos[$otroCampo]) && $value !== $datos[$otroCampo];
        });
    }
}
