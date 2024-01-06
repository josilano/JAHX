<?php

namespace App\Providers;

use App\Categoria;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CategoriaServiceProvider extends ServiceProvider
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
        App::bind('categoria', function ()
        {
            return new Categoria();
        });
    }
}
