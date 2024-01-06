<?php

namespace App\Http\Controllers;

use App\Facades\CompraFacade;
use App\Facades\VendaFacade;
use App\Facades\CustoFacade;
use App\Facades\CaixaFacade;

use Illuminate\Http\Request;

class ContaController extends Controller
{
    const SEM_MSG_TELA = 9;

    public function __construct()
	{
		$this->middleware('auth');
	}

    //a pagar
	private function dashboardContasAPagar($cadcompra, $cadcompraexception)
	{
        $compras = CompraFacade::where('restante', '>', '0')->orderBy('id', 'desc')->paginate(10);
        $custos = CustoFacade::all();
        $totalapagar = CompraFacade::where('restante', '>', '0')->sum('restante');
        //$mes_atual = strftime('%m');
//        $custo_com_pagamento = CustoFacade::leftJoin('caixas', 'custos.custo', '=', 'caixas.descricao')
//        ->select('custos.*', 'caixas.*')
//        ->whereMonth('caixas.data_pagamento', $mes_atual)
//        ->get();dd($custo_com_pagamento);
        $custo_com_pagamento = CustoFacade::leftJoin('caixas', function ($join){
            $mes_atual = strftime('%m');
            $join->on('custos.custo', '=', 'caixas.custo_fixo')
            ->whereMonth('caixas.data_pagamento', $mes_atual);
        })->get();

        return view ('erp.conta.apagar', compact('compras', 'totalapagar', 'custo_com_pagamento'));
    }
    
    public function listAPagar()
	{
		return $this->dashboardContasAPagar(self::SEM_MSG_TELA, null);
    }

    public function store(Request $request)
    {
        $custosok = [];
        foreach ($request->custos as $c)
        {
            $caixa = CaixaFacade::novoCaixa();
            $caixa->descricao = $c[0];
            $caixa->usuario_id = $request->user_id;
            $caixa->valor = number_format((double)str_replace(',', '.', str_replace('.', '', $c[1])), 2, '.', '');
            $caixa->operacao = "Sangria";
            $caixa->data_pagamento = utf8_encode(strftime('%Y-%m-%d', strtotime(str_replace('/', '-', $c[2]))));
            $caixa->custo_fixo = $c[0];
            array_push($custosok, $res = $caixa->save());
        }
        return response($custosok, 200);
    }
    
    //a receber
    private function dashboardContasAReceber()
	{
        $vendas = VendaFacade::where('restante', '>', '0')->orderBy('id', 'desc')->paginate(10);
        $vendas_sem_paginate = VendaFacade::where('restante', '>', '0')->orderBy('id', 'desc')->get();
        $vendas_agrupadas = VendaFacade::selectRaw('SUM(restante) as total_restante, COUNT(id) as qtd_restante, id_cliente')
        ->where('restante', '>', '0')
        ->groupBy('id_cliente')->get();//having('restante', '>', '0')->get();//->orderBy('id', 'desc')->paginate(10);
        //dd($vendas_agrupadas);
        $totalareceber = VendaFacade::where('restante', '>', '0')->sum('restante');
        
        return view ('erp.conta.areceber', compact('vendas', 'totalareceber', 'vendas_agrupadas', 'vendas_sem_paginate'));
    }
    
    public function listAReceber()
	{
		return $this->dashboardContasAReceber();
    }

	private function mostraCompra($compra, $compraexception, $itensCompra, $cliente, $upcompra, $upcompraexception, $usuario_criador)
    {
        return view ('erp.compra.compra', compact('compra', 'compraexception', 'itensCompra', 'cliente', 'upcompra', 'upcompraexception', 'usuario_criador'));
    }

	public function create()
	{
		//$fornecedores = FornecedorFacade::listarFornecedoresSomentePorNome();
		//$produtos = ProdutoFacade::listarProdutosSomentePorDescricao();
		//$fornecedor = FornecedorFacade::find(1);

		//return view ('erp.compra.criarcompra', compact('fornecedores', 'produtos', 'fornecedor'));
    }
}
