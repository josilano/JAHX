<?php

namespace App\Providers;

use App\FormaPagamento;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class FormaPagamentoServiceProvider extends ServiceProvider
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
        App::bind('formapagamento', function ()
        {
            return new FormaPagamento();
        });
    }
}
