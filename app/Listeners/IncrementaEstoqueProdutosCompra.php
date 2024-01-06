<?php

namespace App\Listeners;

use App\Events\FinalizouItensCompra;
use App\Facades\CompraFacade;
use App\Facades\ProdutoFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncrementaEstoqueProdutosCompra
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
     * @param  FinalizouItensCompra  $event
     * @return void
     */
    public function handle(FinalizouItensCompra $event)
    {
        $produtos = CompraFacade::find($event->getIdCompra())->itensCompra;
        foreach ($produtos as $produto) {
            $incremento = ProdutoFacade::where('id', $produto->id_produto)->increment('qtd', $produto->qtd_compra);
        }
        return $incremento;
    }
}
