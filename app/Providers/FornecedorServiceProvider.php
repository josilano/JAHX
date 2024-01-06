<?php

namespace App\Providers;

use App\Fornecedor;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class FornecedorServiceProvider extends ServiceProvider
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
        App::bind('fornecedor', function ()
        {
            return new Fornecedor();
        });
    }
}
