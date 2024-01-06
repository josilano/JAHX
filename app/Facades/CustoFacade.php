<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CustoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'custo';
    }
}