<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class CategoriaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'categoria';
    }
}