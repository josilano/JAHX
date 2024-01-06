<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class VendaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'venda';
    }
}