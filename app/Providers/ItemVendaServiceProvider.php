<?php

namespace App\Providers;

use App\ItemVenda;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ItemVendaServiceProvider extends ServiceProvider
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
        App::bind('itemvenda', function ()
        {
            return new ItemVenda();
        });
    }
}
