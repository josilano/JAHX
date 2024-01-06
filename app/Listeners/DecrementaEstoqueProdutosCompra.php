<?php

namespace App\Listeners;

use App\Events\CancelouCompra;
use App\Facades\ProdutoFacade;
use App\Facades\CompraFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DecrementaEstoqueProdutosCompra
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CancelouCompra  $event
     * @return void
     */
    public function handle(CancelouCompra $event)
    {
        $produtos = CompraFacade::find($event->getIdCompra())->itensCompra;
        foreach ($produtos as $produto) {
            $decremento = ProdutoFacade::where('id', $produto->id_produto)->decrement('qtd', $produto->qtd_compra);
        }
        return $decremento;
    }
}
