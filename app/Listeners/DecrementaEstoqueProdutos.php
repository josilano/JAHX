<?php

namespace App\Listeners;

use App\Events\FinalizouItensVenda;
use App\Facades\VendaFacade;
use App\Facades\ProdutoFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DecrementaEstoqueProdutos
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
     * @param  FinalizouItensVenda  $event
     * @return void
     */
    public function handle(FinalizouItensVenda $event)
    {
        $produtos = VendaFacade::find($event->getIdVenda())->itensVenda;
        foreach ($produtos as $produto) {
            $produto_id = ProdutoFacade::where('descricao', $produto->descricao_produto)->value('id');
            $decremento = ProdutoFacade::where('id', $produto_id)->decrement('qtd', $produto->qtd_venda);
        }
        return $decremento;
    }
}
