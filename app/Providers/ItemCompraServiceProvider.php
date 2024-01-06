<?php

namespace App\Providers;

use App\ItemCompra;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ItemCompraServiceProvider extends ServiceProvider
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
        App::bind('itemcompra', function ()
        {
            return new ItemCompra();
        });
    }
}
