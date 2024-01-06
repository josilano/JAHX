<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class ItemPreVendaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'itemprevenda';
    }
}