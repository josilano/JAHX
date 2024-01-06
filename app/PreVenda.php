<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreVenda extends Model
{
    protected $table = 'prevendas';

    protected $fillable = [
    	'id_cliente',
    	'id_usuario',
        'total_itens',
        'tipo_desconto',
        'desconto',
    	'total_venda',
    	'forma_pg_venda',
    	'parcelas',
        'status',
        'dinheiro',
        'troco',
        'observacoes',
        'setor_venda',
        'restante'
    ];

    public function novaPreVenda()
    {
        return new PreVenda();
    }

    public function setStatusPreVenda($id, $status)
    {
        $dav = PreVenda::find($id);
        $dav->status = $status;
        $dav->save();
        return $dav;
    }

    public function itensPreVenda()
    {
        return $this->hasMany('App\ItemPreVenda', 'id_prevenda');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'id_cliente');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }

    public function listarPreVendasSomentePorDescricao()
    {
        $davs = PreVenda::select('id')->get();
        return $davs;
    }
}
