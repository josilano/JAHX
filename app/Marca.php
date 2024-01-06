<?php

namespace App;

use App\Marca;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['nome_marca'];

    public function novaMarca()
    {
        return new Marca();
    }

    public function cadastrarMarca(Marca $marca)
    {
    	try
    	{
    		$marca->save();
            if($marca->wasRecentlyCreated) return $marca;

            return null;
    	}
    	catch(\Exception $ex)
    	{
            return $ex;
    	}
    }

    public function listarMarca()
    {
    	try
    	{
    		$marcas = Marca::all();
            
            if ($marcas == null) return null;
            
    		return $marcas;
    	}
    	catch(\Exception $ex)
    	{
            return $ex;
    	}
    }

    public function listarMarcaPaginada($qtd_por_pag)
    {
        try
        {
            $marcas = Marca::paginate($qtd_por_pag);
            
            if ($marcas == null) return null;
            
            return $marcas;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function getMarcaPorNome($slug)
    {
        try
        {
            $marcas = Marca::where('nome_marca', 'like', '%'.$slug.'%')->first();
            
            //if ($produtos == null) return response(null, 404);
            if ($marcas == null) return null;

            return $marcas;
        }
        catch(\Exception $ex)
        {
            //return response(null, 500)->withException($ex);
            return $ex;
        }
    }

    public function getMarca($id)
    {
        try
        {
            $marca = Marca::find($id);
            
            //if ($produtos == null) return response(null, 404);
            if ($marca == null) return null;

            return $marca;
        }
        catch(\Exception $ex)
        {
            //return response(null, 500)->withException($ex);
            return $ex;
        }
    }

    public function atualizaMarca(Marca $marca)
    {
        try
        {
            if ($marca->save()) return $marca;
            
            return null;
        }
        catch(\Exception $ex)
        {
            //return response(null, 500)->withException($ex);
            return $ex;
        }
    }
}
