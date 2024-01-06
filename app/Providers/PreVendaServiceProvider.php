<?php

namespace App\Providers;

use App\PreVenda;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class PreVendaServiceProvider extends ServiceProvider
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
        App::bind('prevenda', function ()
        {
            return new PreVenda();
        });
    }
}
