<?php

namespace App\Providers;

use App\Marca;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class MarcaServiceProvider extends ServiceProvider
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
        App::bind('marca', function ()
        {
            return new Marca();
        });
    }
}
