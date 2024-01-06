<?php

namespace App\Http\Controllers;

use App\Facades\ProdutoFacade;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    public function __construct()
	{
		$this->middleware('auth');
	}

    public function getProduto($slug)
    {
        $produto = ProdutoFacade::getProdutoPorDescricao($slug);
        $produtoexception = ($produto instanceof \Exception) ? $produto : null;
        return $produto;
    }

    public function showEstoque()
    {
        $produtos = ProdutoFacade::orderBy('qtd')->paginate(20);
        $produtosall = ProdutoFacade::all();
        return view ('erp.estoque.estoque', compact('produtos', 'produtosall'));
    }

    public function getProdutoEstoquePorDescricao($descricao)
    {
        $produto = ProdutoFacade::where('descricao', $descricao)->first();
        $produtosall = ProdutoFacade::all();
        return view ('erp.estoque.estoquegetproduto', compact('produto', 'produtosall'));
    }

    public function destroy($id)
    {
    	return ProdutoFacade::where('id', $id)->delete();
    }

    public function getProdutoPorEan($ean)
    {
        //$codigo_ean = explode("",$ean);
        //dd($ean[0]);
        if ($ean[0] == 2)
        {
            //vem da balança
            $ean = substr($ean, 1, 4);
        }
        $produto = ProdutoFacade::where('ean', $ean)->first();
        $produtoexception = ($produto instanceof \Exception) ? $produto : null;
        if (isset($produto)) return response($produto, 200);
        else return response($produto, 204);
    }
}
