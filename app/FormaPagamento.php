<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $fillable = [
    	'forma'
    ];

    public function novaFormaPagamento()
    {
        return new FormaPagamento();
    }

    public function cadastrarFormaPagamento(FormaPagamento $fpagamento)
    {
    	try
    	{
    		$fpagamento->save();
            if($fpagamento->wasRecentlyCreated) return $fpagamento;

            return null;
    	}
    	catch(\Exception $ex)
    	{
    		return $ex;
    	}
    }

    public function listarFormaPagamento()
    {
        try
        {
            $fpagamento = FormaPagamento::all();
            
            if ($fpagamento == null) return null;

            return $fpagamento;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function listarFormaPagamentoPaginada($qtd_por_pag)
    {
        try
        {
            $fpagamento = FormaPagamento::paginate($qtd_por_pag);
            
            if ($fpagamento == null) return null;

            return $fpagamento;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function getFormaPagamentoPorForma($slug)
    {
        try
        {
            $fpagamento = FormaPagamento::where('forma', 'like', '%'.$slug.'%')->first();
            
            if ($fpagamento == null) return null;

            return $fpagamento;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function getFormaPagamento($id)
    {
        try
        {
            $fpagamento = FormaPagamento::find($id);
            
            if ($fpagamento == null) return null;

            return $fpagamento;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function atualizaFormaPagamento(FormaPagamento $fpagamento)
    {
        try
        {
            if ($fpagamento->save()) return $fpagamento;
            
            return null;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }
}
