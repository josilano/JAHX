<?php

namespace App\Http\Controllers;

use App\Events\FinalizouVenda;
use App\Events\CancelouVenda;
use App\Events\VendaDinheiroECartao;
use App\Facades\VendaFacade;
use App\Facades\ClienteFacade;
use App\Facades\ProdutoFacade;
use App\Facades\CaixaFacade;
use App\Facades\ItemVendaFacade;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    const SEM_MSG_TELA = 9;
    const QTD_REQUEST_SEM_ITEM = 16;//15
    const QTD_ATRIBUTOS_ITEM = 6;

    public function __construct()
	{
		$this->middleware('auth');
	}

	private function dashboardVendas($cadvenda, $cadvendaexception, $data_da_venda)
	{
        $listavendas = VendaFacade::listarVendasSomentePorDescricao();
        if (!isset($data_da_venda))
            $data_da_venda = strftime('%Y-%m-%d');
        else
            $data_da_venda = strftime('%Y-%m-%d', strtotime($data_da_venda));
        $vendas = VendaFacade::whereDate('created_at', $data_da_venda)->orderBy('id', 'desc')->paginate(20);
        if ($vendas instanceof \Exception) $vendasexception = $vendas;
        
        return view ('erp.venda.vendas', compact('vendas', 'vendasexception', 'cadvenda', 'cadvendaexception', 'listavendas'));
	}

	private function mostraVenda($venda, $vendaexception, $itensVenda, $cliente, $upvenda, $upvendaexception, $usuario_criador)
    {
        return view ('erp.venda.venda', compact('venda', 'vendaexception', 'itensVenda', 'cliente', 'upvenda', 'upvendaexception', 'usuario_criador'));
    }

    public function index()
	{
		return $this->dashboardVendas(self::SEM_MSG_TELA, null, null);
	}

	public function create()
	{
		//$clientes = ClienteFacade::listarClientesSomentePorNome();
		$produtos = ProdutoFacade::listarProdutosSomentePorDescricao();
        $cliente = ClienteFacade::find(1);
        $clientesall = ClienteFacade::where('status', 'ativo')->get();//all();

		return view ('erp.venda.criarvenda', compact('clientesall', 'produtos', 'cliente'));
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
                if ($i - count($itens) == 15) return back()->with('msg', 'Venda com itens vazios. Favor incluir um produto ou retirar o item')->withInput();
                elseif ($request->has('ean' . $i)){
                    $itemVenda = ItemVendaFacade::novoItemVenda();
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
            $venda = VendaFacade::novaVenda();
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
                if (\Event::fire(new FinalizouVenda($venda->id, $itens))) VendaFacade::setStatusVenda($venda->id, 'finalizada');
            if ($venda->forma_pg_venda == 'DINHEIRO+CARTAO') 
            {
                $registra_livro_caixa_suprimento = \Event::fire(new VendaDinheiroECartao($venda->id, $request->get('valor-cartao'), $venda->id_usuario));
                if ($registra_livro_caixa_suprimento[0]->wasRecentlyCreated) 
                {    
                    $venda->observacoes = 'Suprimento '.$registra_livro_caixa_suprimento[0]->id.'. '.$venda->observacoes;
                    $venda->save();
                }
                else VendaFacade::setStatusVenda($venda->id, 'pendente');
            }
                    
            $vendaexception = ($venda instanceof \Exception) ? $venda : null;

            return $this->dashboardVendas($venda, $vendaexception, null);

//        		for ($i=1; $i <= ($qtd_request - 10); $i++) {
//        			if ($request->get('descricao' . $i) == null)//problema=qdo excluir item o numero item muda
//        			$itemVenda = ItemVendaFacade::novoItemVenda();
//        			$itemVenda->descricao_produto = $request->get('descricao' . $i);
//        			$itemVenda->ean_produto = $request->get('ean' . $i);
//        			$itemVenda->qtd_venda = $request->get('qtd' . $i);
//        			$itemVenda->preco_vendido = $request->get('preco' . $i);
//        			$itens[$i] = $itemVenda;
//        		}
        }
        else return back()->with('msg', 'Não pode realizar venda sem itens');
    }

	public function showPorSlug($slug)
    {
        $cliente = VendaFacade::getClientePorNome($slug);

        $clienteexception = ($cliente instanceof \Exception) ? $cliente : null;
        
        return $this->mostraVenda($cliente, $clienteexception, self::SEM_MSG_TELA, null);
    }

    public function show($id)
    {
        $venda = VendaFacade::find($id);
        $itensVenda = $venda->itensVenda;
        $cliente = $venda->cliente;
        
        $vendaexception = ($venda instanceof \Exception) ? $venda : null;

        //return view ('erp.venda.venda', compact('venda', 'vendaexception', 'itensVenda', 'cliente'));
        
        return $this->mostraVenda($venda, $vendaexception, $itensVenda, $cliente, self::SEM_MSG_TELA, null, $venda->users->name);
    }

    public function update(Request $request, $id)
    {
        //if (Auth::user()->cargo != 'admin') return back()->with('msg', 'Usuário sem permissão');
        $venda = VendaFacade::find($id);
        if (!is_null($venda) & !($venda instanceof \Exception))
        {
            $qtd_request = count($request->all());
            if ($qtd_request > self::QTD_REQUEST_SEM_ITEM)
            {
                //CHAMAR EVENT PARA INCREMENTAR ESTOQUEPRODUTOS, DEPOIS SEGUE FLUXO NORMAL...
                \Event::fire(new CancelouVenda($id));
                $qtd_itens_enviados = ($qtd_request - self::QTD_REQUEST_SEM_ITEM) / self::QTD_ATRIBUTOS_ITEM;
                $itens = ItemVendaFacade::iteraItens($qtd_itens_enviados, $request->all());
                //dd($itens);
                if ($itens == null) return back()->with('msg', 'Venda com itens vazios. Favor incluir um produto ou retirar o item');

                //$venda->id_cliente = $request->get('id-cliente');
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
                
                ItemVendaFacade::excluir($id);

                if ($venda->save()) 
                    if (\Event::fire(new FinalizouVenda($venda->id, $itens))) $venda = $venda->setStatusVenda($venda->id, 'finalizada');
                if ($venda->forma_pg_venda == 'DINHEIRO+CARTAO') 
                    {
                        if (is_null($venda->observacoes)) VendaFacade::setStatusVenda($venda->id, 'pendente');
                        else 
                        {
                            $caixa_suprimento_id = str_replace('.', '', explode(' ', $venda->observacoes)[1]);
                            $suprimento = CaixaFacade::find($caixa_suprimento_id);
                            $suprimento->valor = number_format((double)str_replace(',', '.', str_replace('.', '', $request->get('valor-cartao'))), 2, '.', '');
                            $suprimento->save();
                        }
                    }
                
                    //$vendaexception = ($venda instanceof \Exception) ? $venda : null;

                $venda = VendaFacade::find($id);
                $itensVenda = $venda->itensVenda;
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

                //return $this->edicaoVenda($cliente, null, $upcliente, $upclienteexception);
                return $this->mostraVenda($venda, $vendaexception, $itensVenda, $cliente, $upvenda, $upvendaexception, $venda->users->name);
            }
            else return back()->with('msg', 'Não pode realizar venda sem itens');
        }
        $vendaexception = ($venda instanceof \Exception) ? $venda : null;

        return $this->mostraVenda($venda, $vendaexception, null, null, null, null, $venda->users->name);
    }

    public function edit($id)
    {
    	$venda = VendaFacade::find($id);
        $itens = $venda->itensVenda;
        $produtos = ProdutoFacade::listarProdutosSomentePorDescricao();
        $id_do_suprimento = explode(' ', $venda->observacoes);
        if (is_null($venda->observacoes) || !isset($id_do_suprimento[1])) $caixa_suprimento_id = 0;
        else $caixa_suprimento_id = str_replace('.', '', $id_do_suprimento);
        if ($venda->forma_pg_venda == 'DINHEIRO+CARTAO')
            $suprimento = CaixaFacade::find($caixa_suprimento_id);
        else $suprimento = null;

    	return view ('erp.venda.editavenda', compact('venda', 'itens', 'produtos', 'suprimento'));
    }

    public function cancelar($id)
    {
        $venda = VendaFacade::find($id);
        $venda->observacoes = $venda->observacoes .'. MOTIVO DO CANCELAMENTO '. \Request::get('observacoes-cancelamento');
        if ($venda->status === 'finalizada')
        {
            $venda->status = 'cancelada';
            $venda->save();
            \Event::fire(new CancelouVenda($id));
        }
        elseif ($venda->status === 'pendente') VendaFacade::setStatusVenda($id, 'cancelada');
        $venda->save();
        return $this->dashboardVendas(self::SEM_MSG_TELA, null, null);
    }

    public function exibirRecibo($id)
    {
        //$produtos = ProdutoFacade::all();
        $venda = VendaFacade::find($id);
        $itens = $venda->itensVenda;
        $cliente = $venda->cliente;
        $nomerecibo = 'RECIBO DE VENDA';
        
        //return view ('erp.pdf.devenda', compact('produtos'));
        return \PDF::loadView('erp.pdf.devenda', compact('venda', 'itens','cliente', 'nomerecibo'))
                // Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape') ledger é cupom
                //->download('danfe.pdf');
                ->stream();
    }

    public function baixarRecibo($id)
    {
        $venda = VendaFacade::find($id);
        $itens = $venda->itensVenda;
        $cliente = $venda->cliente;
        $nomerecibo = 'RECIBO DE VENDA';
        
        return \PDF::loadView('erp.pdf.devenda', compact('venda', 'itens','cliente', 'nomerecibo'))
                ->download('Recibo nº '. $id .'.pdf');
    }

    public function exibirCupom($id)
    {
        $venda = VendaFacade::find($id);
        $itens = $venda->itensVenda;
        $cliente = $venda->cliente;
        $nomerecibo = 'CUPOM DE VENDA';
        
        $id_do_suprimento = explode(' ', $venda->observacoes);
        if (is_null($venda->observacoes) || !isset($id_do_suprimento[1])) $caixa_suprimento_id = 0;
        else $caixa_suprimento_id = str_replace('.', '', $id_do_suprimento);
        if ($venda->forma_pg_venda == 'DINHEIRO+CARTAO')
            $suprimentoEmCartao = CaixaFacade::find($caixa_suprimento_id);
        else $suprimentoEmCartao = 0;

        return \PDF::loadView('erp.pdf.cupom', compact('venda', 'itens','cliente', 'nomerecibo', 'suprimentoEmCartao'))
                ->setPaper([0, 0, 807.874, 221.102], 'landscape')
                ->stream();
    }

    public function exibirVendaDiaCupom(Request $request, $data_venda)
    {
        $data_da_venda = str_replace('-', '/', $data_venda);
        if (!isset($data_da_venda))
            $data_da_venda = strftime('%Y-%m-%d');
        else
            $data_da_venda = strftime('%Y-%m-%d', strtotime($data_venda));
        $totalvendas = VendaFacade::whereDate('created_at', $data_da_venda)
            ->where('status', 'finalizada')
            ->sum('total_venda');
        $totalvendascartao = VendaFacade::whereDate('created_at', $data_da_venda)
            ->where([
                ['status', 'finalizada'],
                ['forma_pg_venda', 'like', '%cartao%']
            ])
            //->whereIn('forma_pg_venda', ['cartao de credito', 'cartao de debito'])
            ->sum('total_venda');
        $totalvendasdinheiro = VendaFacade::whereDate('created_at', $data_da_venda)
            ->where([
                ['status', '=', 'finalizada'],
                ['forma_pg_venda', 'dinheiro']
            ])
            ->sum('total_venda');
        $totalvendasdinheirocartao = VendaFacade::whereDate('created_at', $data_da_venda)
            ->where([
                ['status', '=', 'finalizada'],
                ['forma_pg_venda', 'dinheiro+cartao']
            ])
            //->sum('dinheiro');
            ->select(\DB::raw('SUM(dinheiro - troco) as vendas_dinheiro_cartao'))->first();//dd($totalvendasdinheirocartao->vendas_dinheiro_cartao);
        $totalvendasitens = ItemVendaFacade::select('descricao_produto', \DB::raw('SUM(qtd_venda) as total_vendido'))
            ->whereDate('created_at', $data_da_venda)
            ->groupBy('descricao_produto')
            ->get();
        $sangrias = CaixaFacade::whereDate('data_pagamento', $data_da_venda)
            ->where('operacao', 'sangria')
            ->get();//dd($sangrias);
        $suprimentos = CaixaFacade::whereDate('data_pagamento', $data_da_venda)
            ->where('operacao', 'suprimento')
            ->get();//dd($suprimentos);
        $totalsangria = CaixaFacade::whereDate('data_pagamento', $data_da_venda)
            ->where('operacao', 'sangria')
            ->sum('valor');//dd($totalsangria);
        $totalsuprimento = CaixaFacade::whereDate('data_pagamento', $data_da_venda)
            ->where('operacao', 'suprimento')
            ->sum('valor');//dd($totalsuprimento);
        //$totalsuprimentocartao = CaixaFacade::whereDate('data_pagamento', $data_da_venda)
        //    ->where([
        //        ['operacao', 'suprimento'],
        //        ['forma_pg', 'dinheiro+cartao']
        //    ])
        //    ->sum('valor');//dd($totalsuprimento);
        $totalsuprimentocartao = CaixaFacade::whereDate('data_pagamento', $data_da_venda)
            ->where([
                ['operacao', 'suprimento'],
                ['forma_pg', 'like', '%cartao%']
            ])
            //->whereIn('forma_pg', ['cartao de credito', 'cartao de debito', 'dinheiro+cartao'])
            ->sum('valor');//dd($totalsuprimento);
        $totalareceber = VendaFacade::whereDate('created_at', $data_da_venda)
            ->where([
                ['restante', '>', '0'],
                ['id_cliente', '<>', 41]
            ])->sum('restante');//retira o consumo da casa, cliente eliza

        /*$qtdvendascartao = VendaFacade::whereDate('created_at', $data_da_venda)
            ->where('status', 'finalizada')
            ->whereIn('forma_pg_venda', ['cartao de credito', 'cartao de debito', 'dinheiro+cartao'])
            ->count('total_venda');
        $qtdvendassomentecredito = VendaFacade::whereDate('created_at', $data_da_venda)
            ->where([
                ['status', 'finalizada'],
                ['forma_pg_venda', 'cartao de credito']
            ])
            ->count('total_venda');
        $qtdvendassomentedebito = VendaFacade::whereDate('created_at', $data_da_venda)
            ->where([
                ['status', 'finalizada'],
                ['forma_pg_venda', 'cartao de debito']
            ])
            ->count('total_venda');
        //dd($qtdvendascartao, $qtdvendassomentecredito, $qtdvendassomentedebito);
        $totalvendastransferenciabancaria = VendaFacade::whereDate('created_at', $data_da_venda)
            ->where([
                ['status', 'finalizada'],
                ['forma_pg_venda', 'transferencia bancaria']
            ])
            ->sum('total_venda');
        $qtdvendastransferenciabancaria = VendaFacade::whereDate('created_at', $data_da_venda)
            ->where([
                ['status', 'finalizada'],
                ['forma_pg_venda', 'transferencia bancaria']
            ])
            ->count('total_venda');*/
        $totaldevendas = VendaFacade::select('forma_pg_venda', \DB::raw('SUM(total_venda) as total_venda'), \DB::raw('COUNT(total_venda) as qtd_venda'))
            ->where([
                ['created_at', 'like', $data_da_venda.'%'],
                ['status', 'finalizada']
            ])
            ->groupBy('forma_pg_venda')
            //->having('status', '=', 'finalizada')
            ->get();

        $totalvendasdinheiro = $totalvendasdinheiro + $totalvendasdinheirocartao->vendas_dinheiro_cartao;
        $totalvendascartao = $totalvendascartao + $totalsuprimentocartao;
        $totalsuprimento = $totalsuprimento - $totalsuprimentocartao;
        $data_da_venda = strftime('%d-%m-%Y', strtotime($data_venda));
        $nomerecibo = 'FECHAMENTO DE CAIXA ERP - VENDA';
        
        return \PDF::loadView('erp.pdf.cupomrelatoriodia', compact('totalvendas', 'totalvendascartao',
         'totalvendasdinheiro', 'totalvendasitens', 'data_da_venda', 'nomerecibo', 'sangrias',
          'suprimentos', 'totalsangria', 'totalsuprimento', 'totalareceber', 'totaldevendas'))
                ->setPaper([0, 0, 807.874, 221.102], 'landscape')
                ->stream();
    }

    public function exibirVendaMesCupom(Request $request, $data_venda)
    {
        $data_da_venda = '01-' . $data_venda;
        if (!isset($data_venda))
            $data_da_venda = strftime('%Y-%m');
        else
            $data_da_venda = strftime('%Y-%m', strtotime($data_da_venda));
        $totalvendas = VendaFacade::where([
                ['created_at', 'like', $data_da_venda.'%'],
                ['status', 'finalizada']
            ])
            ->sum('total_venda');
        $totalvendascartao = VendaFacade::where([
            ['created_at', 'like', $data_da_venda. '%'],
            ['status', 'finalizada'],
            ['forma_pg_venda', 'like', '%cartao%']
            ])
            //->whereIn('forma_pg_venda', ['cartao de credito', 'cartao de debito'])
            ->sum('total_venda');
        $totalvendasdinheiro = VendaFacade::where([
                ['created_at', 'like', $data_da_venda. '%'],
                ['status', '=', 'finalizada'],
                ['forma_pg_venda', 'dinheiro']
            ])
            ->sum('total_venda');
        $totalvendasitens = ItemVendaFacade::select('descricao_produto', \DB::raw('SUM(qtd_venda) as total_vendido'))
            ->where('created_at', 'like', $data_da_venda.'%')
            ->groupBy('descricao_produto')
            ->get();
        $sangrias = CaixaFacade::where([
                ['data_pagamento', 'like', $data_da_venda. '%'],
                ['operacao', 'sangria']
            ])
            ->get();
        $suprimentos = CaixaFacade::where([
                ['data_pagamento', 'like', $data_da_venda. '%'],
                ['operacao', 'suprimento']
            ])
            ->get();//dd($suprimentos);
        $totalsangria = CaixaFacade::where([
                ['data_pagamento', 'like', $data_da_venda. '%'],    
                ['operacao', 'sangria']
            ])
            ->sum('valor');//dd($totalsangria);
        $totalsuprimento = CaixaFacade::where([
                ['data_pagamento', 'like', $data_da_venda. '%'],
                ['operacao', 'suprimento']
            ])
            ->sum('valor');//dd($totalsuprimento);
        $totalareceber = VendaFacade::where([
                ['created_at', 'like', $data_da_venda. '%'],
                ['restante', '>', '0'],
                ['id_cliente', '<>', 41]
            ])
            ->sum('restante');
        $totalvendasdinheirocartao = VendaFacade::where([
                ['created_at', 'like', $data_da_venda. '%'],
                ['status', '=', 'finalizada'],
                ['forma_pg_venda', 'dinheiro+cartao']
            ])
            ->sum('total_venda');
        /*$totalvendastransferenciabancaria = VendaFacade::where([
                ['created_at', 'like', $data_da_venda. '%'],
                ['status', '=', 'finalizada'],
                ['forma_pg_venda', 'pixerencia bancaria']
            ])
            ->sum('total_venda');*/
        $totaldevendas = VendaFacade::select('forma_pg_venda', \DB::raw('SUM(total_venda) as total_venda'), \DB::raw('COUNT(total_venda) as qtd_venda'))
            ->where([
                ['created_at', 'like', $data_da_venda.'%'],
                ['status', 'finalizada']
            ])
            ->groupBy('forma_pg_venda')
            ->get();

        $data_da_venda = $data_venda;
        $nomerecibo = 'FECHAMENTO DE MES DO CAIXA ERP - VENDA';
        
        return \PDF::loadView('erp.pdf.cupomrelatoriomes', compact('totalvendas', 'totalvendascartao',
         'totalvendasdinheiro', 'totalvendasitens', 'data_da_venda', 'nomerecibo', 'sangrias',
          'suprimentos', 'totalsangria', 'totalsuprimento', 'totalareceber', 'totalvendasdinheirocartao',
          'totaldevendas'))
                ->setPaper([0, 0, 807.874, 221.102], 'landscape')
                ->stream();
    }

    public function showPorPeriodo($data_da_venda)
    {
        return $this->dashboardVendas(self::SEM_MSG_TELA, null, $data_da_venda);
    }
    /*retirado do cupom dia
    <div><strong>TOTAL VENDAS NO CARTAO: R$ {{ number_format($totalvendascartao, 2, ',', '.') }}</strong></div>
    <div><strong>TOTAL VENDAS A DINHEIRO: R$ {{ number_format($totalvendasdinheiro, 2, ',', '.') }}</strong></div>
    <div><strong>TOTAL VENDAS TRANSFERENCIA BANCARIA: R$ {{ number_format($totalvendastransferenciabancaria, 2, ',', '.') }}</strong></div>
    <div><strong>FATURAMENTO: R$ {{ number_format($totalvendas, 2, ',', '.') }}</strong></div>
    <span>------------------------------------------------------------------------------------</span>
    <div><strong>QTD VENDAS NO CARTAO: TOTAL {{ $qtdvendascartao }}</strong></div>
    <div><strong>QTD VENDAS SOMENTE CREDITO: {{ $qtdvendassomentecredito }}</strong></div>
    <div><strong>QTD VENDAS SOMENTE DEBITO: {{ $qtdvendassomentedebito }}</strong></div>
    <div><strong>QTD VENDAS SOMENTE DINHEIRO+CARTAO: {{ $qtdvendascartao-$qtdvendassomentecredito-$qtdvendassomentedebito }}</strong></div>
    <span>------------------------------------------------------------------------------------</span>
    <div><strong>QTD VENDAS TRANSFERENCIA BANCARIA: {{ $qtdvendastransferenciabancaria }}</strong></div>*/
}
