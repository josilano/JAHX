<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadeMedida extends Model
{
    protected $fillable = [
    	'sigla',
    	'descricao'
    ];

    public function listarUnidadeMedida()
    {
    	try
    	{
    		$unmedidas = UnidadeMedida::all();
            if ($unmedidas == null) return null;
            
    		return $unmedidas;
    	}
    	catch(\Exception $ex)
    	{
            return $ex;
    	}
    }

    public function listarUnidadeMedidaPaginada($qtd_por_pag)
    {
        try
        {
            $unmedidas = UnidadeMedida::paginate($qtd_por_pag);
            if ($unmedidas == null) return null;
            
            return $unmedidas;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function novaUnidadeMedida()
    {
        return new UnidadeMedida();
    }

    public function cadastrarUnidadeMedida(UnidadeMedida $unmedida)
    {
        try
        {   
            $unmedida->save();
            if($unmedida->wasRecentlyCreated) return $unmedida;

            return null;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function getUnidadeMedidaPorDescricao($slug)
    {
        try
        {
            $unmedida = UnidadeMedida::where('descricao', 'like', '%'.$slug.'%')->first();
            
            if ($unmedida == null) return null;

            return $unmedida;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function getUnidadeMedida($id)
    {
        try
        {
            $unmedida = UnidadeMedida::find($id);
            
            if ($unmedida == null) return null;

            return $unmedida;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function atualizaUnidadeMedida(UnidadeMedida $unmedida)
    {
        try
        {
            if ($unmedida->save()) return $unmedida;
            
            return null;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }
}
