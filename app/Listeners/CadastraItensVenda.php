<?php

namespace App\Listeners;

use App\Events\FinalizouVenda;
use App\Events\FinalizouItensVenda;
use App\Facades\ItemVendaFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CadastraItensVenda
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
     * @param  FinalizouVenda  $event
     * @return void
     */
    public function handle(FinalizouVenda $event)
    {
        $itens = $event->getItens();
        foreach ($itens as $item) {
            $itemVenda = ItemVendaFacade::novoItemVenda();
            $itemVenda = $item;
            $itemVenda->id_venda = $event->getIdVenda();
            $cadItem = $itemVenda->save();
        }
        //return $cadItem;

        if ($cadItem) return \Event::fire(new FinalizouItensVenda($event->getIdVenda()));
        return false;
    }
}
