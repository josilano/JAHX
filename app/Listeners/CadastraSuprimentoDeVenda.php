<?php

namespace App\Listeners;

use App\Events\VendaDinheiroECartao;
use App\Facades\CaixaFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CadastraSuprimentoDeVenda
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
     * @param  VendaDinheiroECartao  $event
     * @return void
     */
    public function handle(VendaDinheiroECartao $event)
    {
        $caixa = CaixaFacade::novoCaixa();
        $caixa->descricao = 'Pagamento no cartão referente a venda '.$event->venda_id;
        $caixa->usuario_id = $event->usuario_id;
        $caixa->valor = number_format((double)str_replace(',', '.', str_replace('.', '', $event->valor)), 2, '.', '');
        $caixa->operacao = 'suprimento';
        $caixa->data_pagamento = strftime('%Y-%m-%d');
        $caixa->custo_fixo = 'Sem Custo';
        $caixa->forma_pg = 'DINHEIRO+CARTAO';
        $caixa->save();
        return $caixa;
    }
}
