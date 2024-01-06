<?php

namespace App\Http\Controllers;

use App\Events\FinalizouPreVenda;
use App\Events\FinalizouVenda;
use App\Facades\PreVendaFacade;
use App\Facades\VendaFacade;
use App\Facades\ClienteFacade;
use App\Facades\ProdutoFacade;
use App\Facades\ItemPreVendaFacade;
use App\Facades\ItemVendaFacade;
use App\Facades\CaixaFacade;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DAVController extends Controller
{
    const SEM_MSG_TELA = 9;
    const QTD_REQUEST_SEM_ITEM = 15;
    const QTD_ATRIBUTOS_ITEM = 6;

    public function __construct()
	{
		$this->middleware('auth');
	}

	private function dashboardDAVs($caddav, $caddavexception, $data_da_venda)
	{
        //$davs = PreVendaFacade::orderBy('id', 'desc')->paginate(10);
        $listadavs = PreVendaFacade::listarPreVendasSomentePorDescricao();
        //$teste = PreVendaFacade::where('updated_at', 'like','2018-08-06%')->get();dd($teste);
        //dd(strftime('%Y-%d-%m', strtotime($data_da_venda)));
        if (!isset($data_da_venda))
            $data_da_venda = strftime('%Y-%m-%d');
        else
            $data_da_venda = strftime('%Y-%m-%d', strtotime($data_da_venda));
        $davs = PreVendaFacade::whereDate('updated_at', $data_da_venda)->orderBy('id', 'desc')->paginate(20);//dd($teste);
        //$teste = PreVendaFacade::whereDate('updated_at', '2018-08-06')->sum('total_venda');dd($teste);
        
        if ($davs instanceof \Exception) $davsexception = $davs;
        
        return view ('erp.dav.davs', compact('davs', 'davsexception', 'caddav', 'caddavexception', 'listadavs'));
	}

	private function mostraDAV($dav, $davexception, $itensPreVenda, $cliente, $updav, $updavexception, $usuario_criador)
    {
        return view ('erp.dav.dav', compact('dav', 'davexception', 'itensPreVenda', 'cliente', 'updav', 'updavexception', 'usuario_criador'));
    }

    public function index()
	{
		return $this->dashboardDAVs(self::SEM_MSG_TELA, null, null);
	}

	public function create()
	{
        //$clientes = ClienteFacade::listarClientesSomentePorNome();
        $clientes = ClienteFacade::select('nome_rsocial', 'nome_fantasia')->get();
		$produtos = ProdutoFacade::listarProdutosSomentePorDescricao();
		$cliente = ClienteFacade::find(1);

		return view ('erp.dav.criardav', compact('clientes', 'produtos', 'cliente'));
	}

	public function store(Request $request)
    {
        //if (Auth::user()->cargo != 'admin') return back()->with('msg', 'Usuário sem permissão');
        $qtd_request = count($request->all());
        if ($qtd_request > self::QTD_REQUEST_SEM_ITEM)
        {
            $itens = [];
            $i = 1;
            while (count($itens) < ($qtd_request - self::QTD_REQUEST_SEM_ITEM) / self::QTD_ATRIBUTOS_ITEM) {
                if ($i - count($itens) == 15) return back()->with('msg', 'Pré-venda com itens vazios. Favor incluir um produto ou retirar o item');
                elseif ($request->has('ean' . $i)){
                    $itemVenda = ItemPreVendaFacade::novoItemPreVenda();
                    $itemVenda->descricao_produto = $request->get('descricao' . $i);
                    $itemVenda->ean_produto = $request->get('ean' . $i);
                    $itemVenda->un_produto = $request->get('un' . $i);
                    $itemVenda->qtd_venda = number_format((double)str_replace(',', '.', $request->get('qtd' . $i)), 3, '.', '');
                    $itemVenda->preco_vendido = number_format((double)str_replace(',', '.', str_replace('.', '', $request->get('preco' . $i))), 2, '.', '');
                    $itemVenda->subtotal = number_format((double)str_replace(',', '.', str_replace('.', '', $request->get('subtotal' . $i))), 2, '.', '');
                    array_push($itens,  $itemVenda);
                    $i++;
                }
                else $i++;
            }
            $venda = PreVendaFacade::novaPreVenda();
            $venda->id_cliente = $request->get('id-cliente');
            $venda->id_usuario = $request->get('id-usuario');
            $venda->total_venda = number_format((double)str_replace(',', '.', str_replace('.', '', $request->total)), 2, '.', '');
            $venda->desconto = $request->desconto;
            $venda->forma_pg_venda = $request->get('forma-pg-venda');
            $venda->parcelas = $request->parcelas;
            $venda->total_itens = number_format((double)str_replace(',', '.', str_replace('.', '', $request->totalitens)), 2, '.', '');
            $venda->tipo_desconto = $request->get('tipo-desconto');
            $venda->status = 'pendente';
            $venda->dinheiro = number_format((double)str_replace(',', '.', str_replace('.', '', $request->dinheiro)), 2, '.', '');
            $venda->troco = number_format((double)str_replace(',', '.', str_replace('.', '', $request->troco)), 2, '.', '');
            $venda->observacoes = $request->observacoes;
            $venda->setor_venda = $request->get('setor-venda');
            $venda->restante = number_format((double)str_replace(',', '.', str_replace('.', '', $request->restante)), 2, '.', '');

            if ($venda->save()) 
                if (\Event::fire(new FinalizouPreVenda($venda->id, $itens))) PreVendaFacade::setStatusPreVenda($venda->id, 'aberta');

            $vendaexception = ($venda instanceof \Exception) ? $venda : null;

            return $this->dashboardDAVs($venda, $vendaexception, null);
        }
        else return back()->with('msg', 'Não pode realizar pré-venda sem itens');
    }

    public function destroy($id)
    {
    	if (ItemPreVendaFacade::where('id_prevenda', $id)->delete() > 0)
    		PreVendaFacade::where('id', $id)->delete();
    		return $this->dashboardDAVs(self::SEM_MSG_TELA, null, null);
    }

    public function showPorSlug($slug)
    {
        $cliente = PreVendaFacade::getFornecedorPorNome($slug);

        $clienteexception = ($cliente instanceof \Exception) ? $cliente : null;
        
        return $this->mostraDAV($cliente, $clienteexception, self::SEM_MSG_TELA, null);
    }

    public function show($id)
    {
        $venda = PreVendaFacade::find($id);
        $itensPreVenda = $venda->itensPreVenda;
        $cliente = $venda->cliente;

        $vendaexception = ($venda instanceof \Exception) ? $venda : null;
        
        return $this->mostraDAV($venda, $vendaexception, $itensPreVenda, $cliente, self::SEM_MSG_TELA, null, $venda->users->name);
    }

    public function edit($id)
    {
    	$dav = PreVendaFacade::find($id);
        $itens = $dav->itensPreVenda;
        $produtos = ProdutoFacade::listarProdutosSomentePorDescricao();
        $cliente = $dav->cliente;
        $clientes = ClienteFacade::listarClientesSomentePorNome();

    	return view ('erp.dav.editadav', compact('dav', 'itens', 'produtos', 'cliente', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        //if (Auth::user()->cargo != 'admin') return back()->with('msg', 'Usuário sem permissão');
        $venda = PreVendaFacade::find($id);
        
        if (!is_null($venda) & !($venda instanceof \Exception))
        {
            $qtd_request = count($request->all());
            if ($qtd_request > self::QTD_REQUEST_SEM_ITEM + 1)//era > 11
            {
                $qtd_itens_enviados = ($qtd_request - (self::QTD_REQUEST_SEM_ITEM + 1)) / self::QTD_ATRIBUTOS_ITEM;
                $itens = ItemPreVendaFacade::iteraItens($qtd_itens_enviados, $request->all());
                
                if ($itens == null) return back()->with('msg', 'Venda com itens vazios. Favor incluir um produto ou retirar o item');

                $venda->id_cliente = $request->get('id-cliente');
                $venda->id_usuario = $request->get('id-usuario');
                $venda->total_venda = number_format((double)str_replace(',', '.', str_replace('.', '', $request->total)), 2, '.', '');
                $venda->desconto = $request->desconto;
                $venda->forma_pg_venda = $request->get('forma-pg-venda');
                $venda->parcelas = $request->parcelas;
                $venda->total_itens = number_format((double)str_replace(',', '.', str_replace('.', '', $request->totalitens)), 2, '.', '');
                $venda->tipo_desconto = $request->get('tipo-desconto');
                $venda->dinheiro = number_format((double)str_replace(',', '.', str_replace('.', '', $request->dinheiro)), 2, '.', '');
                $venda->troco = number_format((double)str_replace(',', '.', str_replace('.', '', $request->troco)), 2, '.', '');
                $venda->observacoes = $request->observacoes;
                //$venda->setor_venda = $request->get('setor-venda');
                $venda->restante = number_format((double)str_replace(',', '.', str_replace('.', '', $request->restante)), 2, '.', '');
                
                ItemPreVendaFacade::excluir($id);

                if ($venda->save()) 
                    if (\Event::fire(new FinalizouPreVenda($venda->id, $itens))) $venda = $venda->setStatusPreVenda($venda->id, 'aberta');

                $venda = PreVendaFacade::find($id);
                $itensVenda = $venda->itensPreVenda;
                $cliente = $venda->cliente;

                if ($venda instanceof \Exception)
                {
                    $upvendaexception = $venda;
                    $upvenda = self::SEM_MSG_TELA;
                    $vendaexception = $venda;
                }
                else
                {
                    $upvendaexception = null;
                    $upvenda = $venda;
                    $vendaexception = null;
                }

                return $this->mostraDAV($venda, $vendaexception, $itensVenda, $cliente, $upvenda, $upvendaexception, $venda->users->name);
            }
            else return back()->with('msg', 'Não pode realizar venda sem itens');
        }
        $vendaexception = ($venda instanceof \Exception) ? $venda : null;

        return $this->mostraDAV($venda, $vendaexception, null, null, null, null, $venda->users->name);
    }

    public function exibirRecibo($id)
    {
        $venda = PreVendaFacade::find($id);
        $itens = $venda->itensPreVenda;
        $cliente = $venda->cliente;
        $nomerecibo = 'DAV - ORÇAMENTO';
        
        $html = view ('erp.pdf.devenda', compact('venda', 'itens', 'cliente', 'nomerecibo'))->render();

        $pdf = \App::make('dompdf.wrapper');
        //$pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadHTML($html);
        return $pdf->stream();

        return \PDF::loadView('erp.pdf.devenda', compact('venda', 'itens','cliente', 'nomerecibo'))
                ->stream();
    }

    public function baixarRecibo($id)
    {
        $venda = PreVendaFacade::find($id);
        $itens = $venda->itensPreVenda;
        $cliente = $venda->cliente;
        $nomerecibo = 'DAV - ORÇAMENTO';

        $html = view ('erp.pdf.devenda', compact('venda', 'itens', 'cliente', 'nomerecibo'))->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->download('DAV-Orcamento nº ' . $id . '.pdf');
        
        return \PDF::loadView('erp.pdf.devenda', compact('venda', 'itens','cliente', 'nomerecibo'))
                ->download('DAV-Orcamento nº '. $id .'.pdf');
    }

    public function exibirCupom($id)
    {
        $venda = PreVendaFacade::find($id);
        $itens = $venda->itensPreVenda;
        $cliente = $venda->cliente;
        $nomerecibo = 'CUPOM DE VENDA - DAV';
        
        return \PDF::loadView('erp.pdf.cupom', compact('venda', 'itens','cliente', 'nomerecibo'))
                ->setPaper([0, 0, 807.874, 221.102], 'landscape')
                ->stream();
    }

    public function exibirVendaDiaCupom(Request $request, $data_venda)
    {
        $data_da_venda = str_replace('-', '/', $data_venda);//request->get('data-venda');
        if (!isset($data_da_venda))
            $data_da_venda = strftime('%Y-%m-%d');
        else
            $data_da_venda = strftime('%Y-%m-%d', strtotime($data_venda));
        $totalvendas = PreVendaFacade::whereDate('created_at', $data_da_venda)
            //->where([['status', '=', 'aberta'], ['status', '=', 'baixada']])
            //->whereIn('status', ['baixada', 'aberta'])
            ->whereNotIn('status', ['pendente'])
            ->sum('total_venda');//dd($totalvendas);
        $totalvendascartao = PreVendaFacade::whereDate('created_at', $data_da_venda)
            ->whereNotIn('status', ['pendente'])
            //->whereIn('forma_pg_venda', ['cartao de credito', 'cartao de debito', 'dinheiro+cartao'])
            ->whereIn('forma_pg_venda', ['cartao de credito', 'cartao de debito'])
            ->sum('total_venda');//dd($totalvendascartao);
        $totalvendasdinheiro = PreVendaFacade::whereDate('created_at', $data_da_venda)
            ->whereNotIn('status', ['pendente'])    
            ->where('forma_pg_venda', 'dinheiro')
            ->sum('total_venda');//dd($totalvendasdinheiro);
        $totalvendasdinheirocartao = PreVendaFacade::whereDate('created_at', $data_da_venda)
                ->whereNotIn('status', ['pendente'])
                ->where('forma_pg_venda', 'dinheiro+cartao')
                //->sum('total_venda');
                ->select(\DB::raw('SUM(dinheiro - troco) as vendas_dinheiro_cartao'))->first();
        $totalvendasitens = ItemPreVendaFacade::select('descricao_produto', \DB::raw('SUM(qtd_venda) as total_vendido'))
            ->whereDate('created_at', $data_da_venda)
            ->groupBy('descricao_produto')
            ->get();
            //->sum('total_venda');
            //dd($totalvendasitens);
        $sangrias = CaixaFacade::whereDate('data_pagamento', $data_da_venda)
            ->where('operacao', 'sangria')
            ->get();
        $suprimentos = CaixaFacade::whereDate('data_pagamento', $data_da_venda)
            ->where('operacao', 'suprimento')
            ->get();
        $totalsangria = 0;
        $totalsuprimento = 0;
        $totalsuprimentocartao = 0;
        $totalareceber = 0;
        /*$qtdvendascartao = PreVendaFacade::whereDate('created_at', $data_da_venda)
            ->whereNotIn('status', ['pendente'])
            ->whereIn('forma_pg_venda', ['cartao de credito', 'cartao de debito', 'dinheiro+cartao'])
            ->count('total_venda');
        $qtdvendassomentecredito = PreVendaFacade::whereDate('created_at', $data_da_venda)
            ->whereNotIn('status', ['pendente'])
            ->where('forma_pg_venda', 'cartao de credito')
            ->count('total_venda');
        $qtdvendassomentedebito = PreVendaFacade::whereDate('created_at', $data_da_venda)
            ->whereNotIn('status', ['pendente'])
            ->where('forma_pg_venda', 'cartao de debito')
            ->count('total_venda');
        $totalvendastransferenciabancaria = PreVendaFacade::whereDate('created_at', $data_da_venda)
            ->whereNotIn('status', ['pendente'])
            ->where('forma_pg_venda', 'transferencia bancaria')
            ->sum('total_venda');
        $qtdvendastransferenciabancaria  = PreVendaFacade::whereDate('created_at', $data_da_venda)
            ->whereNotIn('status', ['pendente'])
            ->where('forma_pg_venda', 'transferencia bancaria')
            ->count('total_venda');*/
            $totaldevendas = PreVendaFacade::select('forma_pg_venda', \DB::raw('SUM(total_venda) as total_venda'), \DB::raw('COUNT(total_venda) as qtd_venda'))
            ->where([
                ['created_at', 'like', $data_da_venda.'%'],
                ['status', '<>', 'pendente']
            ])
            ->groupBy('forma_pg_venda')
            ->get();
        
        $totalvendasdinheiro = $totalvendasdinheiro + $totalvendasdinheirocartao->vendas_dinheiro_cartao;
        $totalvendascartao = $totalvendascartao + $totalsuprimentocartao;
        $totalsuprimento = $totalsuprimento - $totalsuprimentocartao;

        $data_da_venda = strftime('%d-%m-%Y', strtotime($data_venda));//$request->get('data-venda');
        //$venda = PreVendaFacade::find();
        //$itens = $venda->itensPreVenda;
        //$cliente = $venda->cliente;
        $nomerecibo = 'FECHAMENTO DE CAIXA ERP - DAV';
        
        return \PDF::loadView('erp.pdf.cupomrelatoriodia', //compact('totalvendas', 'totalvendascartao', 'totalvendasdinheiro', 'totalvendasitens', 'data_da_venda', 'nomerecibo'))
            compact('totalvendas', 'totalvendascartao',
                'totalvendasdinheiro', 'totalvendasitens', 'data_da_venda', 'nomerecibo', 'sangrias',
                'suprimentos', 'totalsangria', 'totalsuprimento', 'totalareceber', 'totaldevendas'))    
            ->setPaper([0, 0, 807.874, 221.102], 'landscape')
            ->stream();
    }

    public function venderDAV($id)
    {
    	$dav = PreVendaFacade::find($id);
    	$itensPreVenda = PreVendaFacade::find($id)->itensPreVenda;
    	$venda = VendaFacade::novaVenda();
    	
    	$venda->id_cliente = $dav->id_cliente;
        $venda->id_usuario = $dav->id_usuario;
        $venda->total_venda = $dav->total_venda;
        $venda->desconto = $dav->desconto;
        $venda->forma_pg_venda = $dav->forma_pg_venda;
        $venda->parcelas = $dav->parcelas;
        $venda->total_itens = $dav->total_itens;
        $venda->tipo_desconto = $dav->tipo_desconto;
        $venda->dinheiro = $dav->dinheiro;
        $venda->troco = $dav->troco;
        $venda->observacoes = $dav->observacoes;
        $venda->setor_venda = $dav->setor_venda;

    	$dav->status = 'baixada';
    	$venda->status = 'pendente';
    	$itens = [];
    	foreach ($itensPreVenda as $item) {
    		$itemVenda = ItemVendaFacade::novoItemVenda();
            $itemVenda->descricao_produto = $item->descricao_produto;
            $itemVenda->ean_produto = $item->ean_produto;
            $itemVenda->un_produto = $item->un_produto;
            $itemVenda->qtd_venda = $item->qtd_venda;
            $itemVenda->preco_vendido = $item->preco_vendido;
            $itemVenda->subtotal = $item->subtotal;
            array_push($itens,  $itemVenda);
    	}

    	if ($venda->save()) 
        	if (\Event::fire(new FinalizouVenda($venda->id, $itens)))
        	{
        		$venda = $venda->setStatusVenda($venda->id, 'finalizada');
        		$dav->save();
        	}
        $cliente = PreVendaFacade::find($id)->cliente;

        if ($venda instanceof \Exception)
        {
            $upvendaexception = $venda;
            $upvenda = self::SEM_MSG_TELA;
            $vendaexception = $venda;
        }
        else
        {
            $upvendaexception = null;
            $upvenda = $venda;
            $vendaexception = null;
        }

        return $this->mostraDAV($venda, $vendaexception, $itensPreVenda, $cliente, $upvenda, $upvendaexception, $dav->users->name);
    }

    public function showPorPeriodo($data_da_venda)
    {
        return $this->dashboardDAVs(self::SEM_MSG_TELA, null, $data_da_venda);
    }
}
