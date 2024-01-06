<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
    	'nome_categoria'
    ];

    public function listarCategoria()
    {
    	try
    	{
    		$categorias = Categoria::all();
            if ($categorias == null) return null;
            
    		return $categorias;
    	}
    	catch(\Exception $ex)
    	{
            return $ex;
    	}
    }

    public function listarCategoriaPaginada($qtd_por_pag)
    {
        try
        {
            $categorias = Categoria::paginate($qtd_por_pag);
            if ($categorias == null) return null;
            
            return $categorias;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function novaCategoria()
    {
        return new Categoria();
    }

    public function cadastrarCategoria(Categoria $categoria)
    {
        try
        {            
            $categoria->save();
            if($categoria->wasRecentlyCreated) return $categoria;

            return null;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function getCategoriaPorNome($slug)
    {
        try
        {
            $categoria = Categoria::where('nome_categoria', 'like', '%'.$slug.'%')->first();
            
            if ($categoria == null) return null;

            return $categoria;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function getCategoria($id)
    {
        try
        {
            $categoria = Categoria::find($id);
            
            if ($categoria == null) return null;

            return $categoria;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }

    public function atualizaCategoria(Categoria $categoria)
    {
        try
        {
            if ($categoria->save()) return $categoria;
            
            return null;
        }
        catch(\Exception $ex)
        {
            return $ex;
        }
    }
}
