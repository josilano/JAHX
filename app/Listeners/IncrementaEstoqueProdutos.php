<?php

namespace App\Listeners;

use App\Events\CancelouVenda;
use App\Facades\VendaFacade;
use App\Facades\ProdutoFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncrementaEstoqueProdutos
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
     * @param  CancelouVenda  $event
     * @return void
     */
    public function handle(CancelouVenda $event)
    {
        $produtos = VendaFacade::find($event->getIdVenda())->itensVenda;
        foreach ($produtos as $produto) {
            $produto_id = ProdutoFacade::where('descricao', $produto->descricao_produto)->value('id');
            $incremento = ProdutoFacade::where('id', $produto_id)->increment('qtd', $produto->qtd_venda);
        }
        return $incremento;
    }
}
