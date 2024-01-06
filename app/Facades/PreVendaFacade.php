<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class PreVendaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'prevenda';
    }
}