<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
    	'numero_nota',
    	'id_fornecedor',
    	'id_usuario',
    	'data_emissao',
        'total_compra',
    	'forma_pg_compra',
    	'parcelas',
        'status',
        'vencimento',
        'restante'
    ];

    public function novaCompra()
    {
        return new Compra();
    }

    public function setStatusCompra($id, $status)
    {
        $compra = Compra::find($id);
        $compra->status = $status;
        $compra->save();
        return $compra;
    }

    public function itensCompra()
    {
        return $this->hasMany('App\ItemCompra', 'id_compra');
    }

    public function fornecedor()
    {
        return $this->belongsTo('App\Fornecedor', 'id_fornecedor');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }

    public function listarComprasSomentePorDescricao()
    {
        $compras = Compra::select('id')->get();
        return $compras;
    }
}
