<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class ItemCompraFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'itemcompra';
    }
}