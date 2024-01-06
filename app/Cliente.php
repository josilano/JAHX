<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    protected $fillable = [
    	'pessoa_tipo',
    	'nome_rsocial',
    	'cpf_cnpj',
    	'nome_fantasia',
    	'email',
    	'logradouro',
    	'numero',
    	'complemento',
    	'bairro',
    	'cidade',
    	'estado',
    	'cep',
    	'tel_principal',
        'tel_secundario',
        'status'
    ];

    public function novoCliente()
    {
        return new Cliente();
    }

    public function getClientePorNome($slug)
    {
        try
        {
            $cliente = Cliente::where('nome_rsocial', 'like', '%'.$slug.'%')->first();
            
            if ($cliente == null) return null;

            return $cliente;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function listarClientesSomentePorNome()
    {
        $clientes = DB::table('clientes')->select('nome_rsocial')->get();
        return $clientes;
    }

    public function vendas()
    {
        return $this->hasMany('App\Venda', 'id_venda');
    }
}
