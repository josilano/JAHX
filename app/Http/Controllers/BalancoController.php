<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Facades\VendaFacade;
use App\Facades\ItemVendaFacade;
use App\Facades\CompraFacade;
use App\Facades\ItemCompraFacade;
use App\Facades\ProdutoFacade;
use App\Facades\CaixaFacade;
use App\Facades\CustoFacade;

class BalancoController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	private function dashboard($mes_do_balanco)
	{
        //precisa itens_vendidos e sua compra e venda, alem dos custos

        $mes_do_balanco_solicitado = '01-' . $mes_do_balanco;
        if (!isset($mes_do_balanco))
            $mes_do_balanco = strftime('%Y-%m');
        else
            $mes_do_balanco= strftime('%Y-%m', strtotime($mes_do_balanco_solicitado));
        /*
        $vendas = VendaFacade::join('item_vendas', 'vendas.id', '=', 'item_vendas.id_venda')
            ->select('item_vendas.descricao_produto', 'item_vendas.qtd_venda', 'item_vendas.preco_vendido')
            ->where([
            ['vendas.created_at', 'like', $mes_do_balanco.'%'],
            ['vendas.status', 'finalizada']
            ])
            ->get();
        $itensvendas = ItemVendaFacade::select('descricao_produto', \DB::raw('SUM(subtotal) as total_itens'))
        ->where('created_at', 'like', $mes_do_balanco.'%')
        ->groupBy('descricao_produto')
        ->get();
        $itens = ProdutoFacade::join('item_compras', 'produtos.id', '=', 'item_compras.id_produto')
        ->join('item_vendas', 'produtos.descricao', '=', 'item_vendas.descricao_produto')
        ->join('vendas', 'item_vendas.id_venda', '=', 'vendas.id')
        ->select('produtos.descricao', 'item_compras.preco_compra', 'item_vendas.preco_vendido', 'item_vendas.qtd_venda')
        ->where([['vendas.created_at', 'like', $mes_do_balanco.'%'], ['vendas.status', 'finalizada']])
        ->get();
        $preco_de_compra = ProdutoFacade::select('produtos.descricao', 'item_compras.preco_compra')//, 'compras.created_at')
        ->join('item_compras', 'produtos.id', '=', 'item_compras.id_produto')
        ->join('item_vendas', 'produtos.descricao', '=', 'item_vendas.descricao_produto')
        ->join('vendas', 'item_vendas.id_venda', '=', 'vendas.id')
        ->where([
            ['vendas.created_at', 'like', $mes_do_balanco.'%'],
            ['vendas.status', 'finalizada']
        ])
        ->distinct()
        //->latest('compras.created_at')
        ->orderBy('produtos.descricao')
        ->get();*/
        $produtos_vendidos_precos_diferentes = ItemVendaFacade::select('produtos.descricao', 'item_vendas.qtd_venda', 'item_vendas.preco_vendido')
            ->join('vendas', 'item_vendas.id_venda', '=', 'vendas.id')
            ->join('produtos', 'produtos.descricao', '=', 'item_vendas.descricao_produto')
            ->where([
                ['vendas.created_at', 'like', $mes_do_balanco.'%'],
                ['vendas.status', 'finalizada']
            ])
            ->whereColumn('item_vendas.preco_vendido', '<>', 'produtos.preco_venda')
        //->groupBy('produtos.descricao')
            ->orderBy('produtos.descricao')
            ->get();
        $qtd_vendida = ItemVendaFacade::select('item_vendas.descricao_produto', \DB::raw('SUM(item_vendas.qtd_venda) as qtd_vendida'))
            ->join('vendas', 'item_vendas.id_venda', '=', 'vendas.id')
        //->join('produtos', 'produtos.descricao', '=', 'item_vendas.descricao_produto')
        //->join('item_compras', 'produtos.id', '=', 'item_compras.id_produto')
            ->where([
                ['vendas.created_at', 'like', $mes_do_balanco.'%'],
                ['vendas.status', 'finalizada']
            ])
        //->distinct()
            //->whereColumn('item_vendas.preco_vendido', '=', 'produtos.preco_venda')
            ->groupBy('item_vendas.descricao_produto')
            ->orderBy('item_vendas.descricao_produto')
            ->get();
        $preco_de_venda = ProdutoFacade::select('produtos.descricao', 'produtos.preco_venda')
            ->join('item_vendas', 'produtos.descricao', '=', 'item_vendas.descricao_produto')
            ->join('vendas', 'vendas.id', '=', 'item_vendas.id_venda')
            ->where([
                ['vendas.created_at', 'like', $mes_do_balanco.'%'],
                ['vendas.status', 'finalizada']
            ])
            ->distinct()
            ->orderBy('produtos.descricao')
            ->get();
        $i = 0;
        $total_margem_contribuicao = 0.00;
        foreach($preco_de_venda as $pv)
        {
            $preco = ItemCompraFacade::select('item_compras.preco_compra')
                ->join('produtos', 'item_compras.id_produto', '=', 'produtos.id')
                ->where('produtos.descricao', $pv->descricao)
                ->latest('item_compras.created_at')
                ->first();
            if (is_null($preco)) {$pv->preco_compra = 0.00;}
            else $pv->preco_compra = $preco->preco_compra;
            $pv->margem_lucro = $pv->preco_venda - $pv->preco_compra;
            $pv->qtd_vendida = $qtd_vendida[$i]->qtd_vendida;
            foreach ($produtos_vendidos_precos_diferentes as $prod_dif)
            {
                if ($prod_dif->descricao === $pv->descricao)
                    {
                        $pv->qtd_vendida -= $prod_dif->qtd_venda;
                        $prod_dif->preco_compra = $pv->preco_compra;
                        $prod_dif->margem_lucro = $prod_dif->preco_vendido - $prod_dif->preco_compra;
                        $prod_dif->margem_contribuicao = $prod_dif->qtd_venda * $prod_dif->margem_lucro;
                        $total_margem_contribuicao += $prod_dif->margem_ontribuicao;
                    }
            }
            $pv->margem_contribuicao = $pv->qtd_vendida * $pv->margem_lucro;
            $total_margem_contribuicao += $pv->margem_contribuicao;
            $i++;
        }
        $total_custos = CaixaFacade::where([
            ['operacao', 'Sangria'],
            ['custo_fixo', '<>', 'Sem Custo'],
            ['data_pagamento', 'like', $mes_do_balanco.'%'],
            ])
            ->sum('valor');
        //dd($mes_do_balanco);
        
        return view ('erp.balancomensal.balanco', compact('produtos_vendidos_precos_diferentes', 'preco_de_venda','total_margem_contribuicao', 'total_custos'));
	}

    public function index()
	{
		return $this->dashboard(null);
    }
    
    public function showPorPeriodo($mes_do_balanco)
	{
		return $this->dashboard($mes_do_balanco);
	}
}
