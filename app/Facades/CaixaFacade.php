<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CaixaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'caixa';
    }
}