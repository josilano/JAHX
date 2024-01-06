<?php

namespace App\Http\Controllers;

use App\Facades\ProdutoFacade;
use Illuminate\Http\Request;

class ItemVendaController extends Controller
{
    protected $tabela_de_produtos;// = [];// = \App\ItemVenda::getItem();

    public function __construct()
	{
		$this->middleware('auth');
		//$this->tabela_de_produtos = collect();// \App\ItemVenda();
	}

	public function inicioTabela()
	{
		$this->tabela_de_produtos = collect();// \App\ItemVenda();
	}

    
/*
* retorna uma tabela renderizada para a view
*/
    public function iteraTabelaItemProdutos(Request $request, $descricao)
    {
    	//dd($request->all());
    	$produto = ProdutoFacade::getProdutoPorDescricao($descricao);
    	$itemVenda = new \App\ItemVenda();
    	$itemVenda->ean_produto = $produto->ean;
    	$itemVenda->descricao_produto = $produto->descricao;
    	$itemVenda->preco_vendido = $produto->preco_venda;
    	$itemVenda->qtd_venda = 1;
    	//\App\ItemVenda::addItemTabela($produto);
    	//$tabela_de_produtos = \App\ItemVenda::getItensTabela();
    	$tabela_de_produtos = $request->session()->get('itensprod', []);
    	$tabela_de_produtos[] = $itemVenda; //$produto;
    	//dd($tabela_de_produtos);
    	$request->session()->put('itensprod', $tabela_de_produtos);//$request->session()->forget('itensprod'); //deleta essa session
    	//dd($request->session()->get('itensprod'));
    	//dd($request->session()->get('itensprod')[0]->ean_produto);
    	//$this->tabela_de_produtos->push($produto);
    	//dd($this->tabela_de_produtos);
    	$html = view ('erp.partials.componentetabelaprodutos', compact('tabela_de_produtos'))->render();
    	return response()->json(compact('html'));
    }

    public function insereItemPDV(Request $request, $id)
    {
        //dd($request->all());
        $produto = ProdutoFacade::find($id);
        $itemVenda = new \App\ItemVenda();
        $itemVenda->ean_produto = $produto->ean;
        $itemVenda->descricao_produto = $produto->descricao;
        $itemVenda->preco_vendido = number_format((double)str_replace(',', '.', str_replace('.', '', $request->get('preco-venda'))), 2, '.', '');
        $itemVenda->qtd_venda = $request->qtd;
        $itemVenda->un_produto = $produto->unidade_medida;
        $itemVenda->subtotal = ($itemVenda->qtd_venda * $itemVenda->preco_vendido);
        //\App\ItemVenda::addItemTabela($produto);
        //$tabela_de_produtos = \App\ItemVenda::getItensTabela();
        $tabela_de_produtos = $request->session()->get('itensprod', []);
        $tabela_de_produtos[] = $itemVenda; //$produto;
        //dd($tabela_de_produtos);
        $request->session()->put('itensprod', $tabela_de_produtos);//$request->session()->forget('itensprod'); //deleta essa session
        //dd($request->session()->get('itensprod'));
        //dd($request->session()->get('itensprod')[0]->ean_produto);
        //$this->tabela_de_produtos->push($produto);
        //dd($this->tabela_de_produtos);
        $html = view ('erp.partials.componenteprodutospdv', compact('tabela_de_produtos'))->render();
        return response()->json(compact('html'));
    }

    public function cancelaItensPDV(Request $request)
    {
        $request->session()->forget('itensprod');
    }
}