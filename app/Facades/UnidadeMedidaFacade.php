<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class UnidadeMedidaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'unidademedida';
    }
}