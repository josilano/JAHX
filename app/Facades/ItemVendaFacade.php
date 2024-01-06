<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class ItemVendaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'itemvenda';
    }
}