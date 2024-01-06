<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custo extends Model
{
    protected $fillable = [
        'custo',
        'usuario_id'
    ];

    public function novoCusto()
    {
        return new Custo();
    }
}
