<?php

namespace App\Listeners;

use App\Events\FinalizouCompra;
use App\Events\FinalizouItensCompra;
use App\Facades\ItemCompraFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CadastraItensCompra
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
     * @param  FinalizouCompra  $event
     * @return void
     */
    public function handle(FinalizouCompra $event)
    {
        $itens = $event->getItens();
        foreach ($itens as $item) {
            $itemCompra = ItemCompraFacade::novoItemCompra();
            $itemCompra = $item;
            $itemCompra->id_compra = $event->getIdCompra();
            $cadItem = $itemCompra->save();
        }

        if ($cadItem) return \Event::fire(new FinalizouItensCompra($event->getIdCompra()));
        return false;
    }
}
