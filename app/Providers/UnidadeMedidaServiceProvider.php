<?php

namespace App\Providers;

use App\UnidadeMedida;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class UnidadeMedidaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('unidademedida', function ()
        {
            return new UnidadeMedida();
        });
    }
}
