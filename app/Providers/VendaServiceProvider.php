<?php

namespace App\Providers;

use App\Venda;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class VendaServiceProvider extends ServiceProvider
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
        App::bind('venda', function ()
        {
            return new Venda();
        });
    }
}
