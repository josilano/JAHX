<?php

namespace App\Providers;

use App\Caixa;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CaixaServiceProvider extends ServiceProvider
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
        App::bind('caixa', function ()
        {
            return new Caixa();
        });
    }
}
