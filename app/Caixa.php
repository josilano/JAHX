<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    protected $fillable = [
        'operacao',
        'usuario_id',
        'descricao',
        'valor',
        'data_pagamento',
        'custo_fixo',
        'forma_pg'
    ];

    public function novoCaixa()
    {
        return new Caixa();
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'usuario_id');
    }
}
