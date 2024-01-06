<?php

namespace App\Providers;

use App\Cliente;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ClienteServiceProvider extends ServiceProvider
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
        App::bind('cliente', function ()
        {
            return new Cliente();
        });
    }
}
