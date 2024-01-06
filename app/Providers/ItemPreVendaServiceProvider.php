<?php

namespace App\Providers;

use App\ItemPreVenda;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ItemPreVendaServiceProvider extends ServiceProvider
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
        App::bind('itemprevenda', function ()
        {
            return new ItemPreVenda();
        });
    }
}
