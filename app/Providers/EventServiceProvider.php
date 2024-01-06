<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //'App\Events\Event' => [
        //    'App\Listeners\EventListener',
        //],
        'App\Events\FinalizouVenda' => [
            'App\Listeners\CadastraItensVenda',
        ],
        'App\Events\FinalizouItensVenda' => [
            'App\Listeners\DecrementaEstoqueProdutos',
        ],
        'App\Events\CancelouVenda' => [
            'App\Listeners\IncrementaEstoqueProdutos',
        ],
        'App\Events\FinalizouCompra' => [
            'App\Listeners\CadastraItensCompra',
        ],
        'App\Events\FinalizouItensCompra' => [
            'App\Listeners\IncrementaEstoqueProdutosCompra',
        ],
        'App\Events\CancelouCompra' => [
            'App\Listeners\DecrementaEstoqueProdutosCompra',
        ],
        'App\Events\FinalizouPreVenda' => [
            'App\Listeners\CadastraItensPreVenda',
        ],
        'App\Events\VendaDinheiroECartao' => [
            'App\Listeners\CadastraSuprimentoDeVenda',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
