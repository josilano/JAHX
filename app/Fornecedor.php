<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';

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
    	'tel_secundario'
    ];

    public function novoFornecedor()
    {
        return new Fornecedor();
    }

    public function getFornecedorPorNome($slug)
    {
        try
        {
            $fornecedor = Fornecedor::where('nome_rsocial', 'like', '%'.$slug.'%')->first();
            
            if ($fornecedor == null) return null;

            return $fornecedor;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function listarFornecedoresSomentePorNome()
    {
        $fornecedores = Fornecedor::select('nome_rsocial')->get();
        return $fornecedores;
    }

    public function compras()
    {
        return $this->hasMany('App\Compra', 'id_compra');
    }
}
