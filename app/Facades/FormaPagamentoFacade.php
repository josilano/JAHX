<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class FormaPagamentoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'formapagamento';
    }
}