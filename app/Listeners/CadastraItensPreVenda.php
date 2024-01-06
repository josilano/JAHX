<?php

namespace App\Listeners;

use App\Events\FinalizouPreVenda;
use App\Facades\ItemPreVendaFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CadastraItensPreVenda
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
     * @param  FinalizouPreVenda  $event
     * @return void
     */
    public function handle(FinalizouPreVenda $event)
    {
        $itens = $event->getItens();
        foreach ($itens as $item) {
            $itemVenda = ItemPreVendaFacade::novoItemPreVenda();
            $itemVenda = $item;
            $itemVenda->id_prevenda = $event->getIdPreVenda();
            $cadItem = $itemVenda->save();
        }
        return $cadItem;
    }
}
