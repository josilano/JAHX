<?php

namespace App\Providers;

use App\Produto;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ProdutoServiceProvider extends ServiceProvider
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
        App::bind('produto', function ()
        {
            return new Produto();
        });
    }
}
