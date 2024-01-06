<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
    	'id_categoria',
    	'descricao',
    	'unidade_medida',
    	'preco_venda',
    	'qtd',
    	'ean',
    	'marca',
        'qtd_minima'
    ];

    public function novoProduto()
    {
        return new Produto();
    }

    public function cadastrarProduto(Produto $produto)
    {
    	try
    	{
    		//$input = \Request::all();
    		//$produto = new Produto();
    		//$produto->fill($request);
            //$produto->id_categoria = $request->get('id-categoria');
            //$produto->unidade_medida = $request->get('un');
    		//$produto->preco_venda = number_format((double)str_replace(',', '.', str_replace('.', '', $request->get('preco-venda'))), 2, '.', '');
            
    		$produto->save();
            if($produto->wasRecentlyCreated) return $produto;

            //return response('cadastrado com sucesso', 201)->header('Location', $produto . '/produtos');
            return null;
    	}
    	catch(\Exception $ex)
    	{
    		return $ex;
    	}
    }

    public function listarProdutosSomentePorDescricao()
    {
        $produtos = DB::table('produtos')->select('descricao')->get();
        return $produtos;
    }

    public function listarProduto()
    {
        try
        {
            $produtos = Produto::all();
            
            //if ($produtos == null) return response(null, 404);
            if ($produtos == null) return null;

            return $produtos;
        }
        catch(\Exception $ex)
        {
            //return response(null, 500)->withException($ex);
            return $ex;
        }
    }

    public function listarProdutoPaginado($qtd_por_pag)
    {
        try
        {
            $produtos = Produto::paginate($qtd_por_pag);
            
            //if ($produtos == null) return response(null, 404);
            if ($produtos == null) return null;

            return $produtos;
        }
        catch(\Exception $ex)
        {
            //return response(null, 500)->withException($ex);
            return $ex;
        }
    }

    public function getProdutoPorDescricao($slug)
    {
        try
        {
            //$produtos = Produto::where('descricao', 'like', '%'.$slug.'%')->first();
            $produtos = Produto::where('descricao', $slug)->first();
            
            //if ($produtos == null) return response(null, 404);
            if ($produtos == null) return null;

            return $produtos;
        }
        catch(\Exception $ex)
        {
            //return response(null, 500)->withException($ex);
            return $ex;
        }
    }

    public function getProduto($id)
    {
        try
        {
            $produto = Produto::find($id);
            
            //if ($produtos == null) return response(null, 404);
            if ($produto == null) return null;

            return $produto;
        }
        catch(\Exception $ex)
        {
            //return response(null, 500)->withException($ex);
            return $ex;
        }
    }

    public function atualizaProduto(Produto $produto)
    {
        try
        {
            if ($produto->save()) return $produto;
            
            return null;
        }
        catch(\Exception $ex)
        {
            //return response(null, 500)->withException($ex);
            return $ex;
        }
    }
}
