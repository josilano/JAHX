<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
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

    public function novaVenda()
    {
        return new Venda();
    }

    public function setStatusVenda($id, $status)
    {
        $venda = Venda::find($id);
        $venda->status = $status;
        $venda->save();
        return $venda;
    }

    public function itensVenda()
    {
        return $this->hasMany('App\ItemVenda', 'id_venda');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'id_cliente');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }

    public function listarVendasSomentePorDescricao()
    {
        $vendas = Venda::select('id')->get();//DB::table('produtos')->select('descricao')->get();
        return $vendas;
    }
}
