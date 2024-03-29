<?php

namespace App\Providers;

use App\Compra;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CompraServiceProvider extends ServiceProvider
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
        App::bind('compra', function ()
        {
            return new Compra();
        });
    }
}
