<?php

namespace App\Providers;

use App\Custo;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CustoServiceProvider extends ServiceProvider
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
        App::bind('custo', function ()
        {
            return new Custo();
        });
    }
}
