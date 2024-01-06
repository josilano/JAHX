<?php

namespace App\Http\Controllers;

use App\Facades\CaixaFacade;
use Illuminate\Http\Request;

class CaixaController extends Controller
{
    const SEM_MSG_TELA = 9;
    
    public function __construct()
	{
		$this->middleware('auth');
	}

	private function dashboardCaixa($cadregcaixa, $cadregcaixaexception, $data_do_regcaixa)
	{
        if (!isset($data_do_regcaixa))
            $data_do_regcaixa = strftime('%Y-%m-%d');
        else
            $data_do_regcaixa = strftime('%Y-%m-%d', strtotime($data_do_regcaixa));
        $registros_caixa = CaixaFacade::whereDate('created_at', $data_do_regcaixa)->orderBy('id', 'desc')->paginate(20);
        if ($registros_caixa instanceof \Exception) $registros_caixaexception = $registros_caixa;
        
        return view ('erp.caixa.caixas', compact('registros_caixa', 'registros_caixaexception', 'cadregcaixa', 'cadregcaixaexception'));
	}

	private function edicaoCaixa($caixa, $caixaexception, $usuario_criador, $upcaixa, $upcaixaexception)
    {
        return view ('erp.caixa.editacaixa', compact('caixa', 'caixaexception', 'usuario_criador', 'upcaixa', 'upcaixaexception'));
    }

    public function index()
	{
		return $this->dashboardCaixa(self::SEM_MSG_TELA, null, null);
    }
    
    public function store(Request $request)
    {    
        $caixa = CaixaFacade::novoCaixa();
        $caixa->descricao = $request->descricao;
        $caixa->usuario_id = $request->get('user-id');
        $caixa->valor = number_format((double)str_replace(',', '.', str_replace('.', '', $request->valor)), 2, '.', '');
        $caixa->operacao = $request->operacao;
        $caixa->data_pagamento = utf8_encode(strftime('%Y-%m-%d', strtotime(str_replace('/', '-', $request->get('data-pagamento-regcaixa')))));
        $caixa->custo_fixo = $request->custo;
        $caixa->forma_pg = $request->get('forma-pg');
        $caixa->save();
        $caixaexception = ($caixa instanceof \Exception) ? $caixa : null;

        return $this->dashboardCaixa($caixa, $caixaexception, null);
    }

    public function showPorPeriodo($data_do_registro)
    {
        return $this->dashboardCaixa(self::SEM_MSG_TELA, null, $data_do_registro);
    }

    public function show($id)
    {
        $caixa = CaixaFacade::find($id);
        $usuario_criador = $caixa->users->name;

        $caixaexception = ($caixa instanceof \Exception) ? $caixa : null;
        
        return $this->edicaoCaixa($caixa, $caixaexception, $usuario_criador, self::SEM_MSG_TELA, null);
    }

    public function update(Request $request, $id)
    {
        $caixa = CaixaFacade::find($id);
        
        if (!is_null($caixa) & !($caixa instanceof \Exception))
        {
            $caixa->descricao = $request->descricao;
            //$caixa->usuario_id = $request->get('user-id');
            $caixa->valor = number_format((double)str_replace(',', '.', str_replace('.', '', $request->valor)), 2, '.', '');
            //$caixa->operacao = $request->operacao;
            $caixa->data_pagamento = utf8_encode(strftime('%Y-%m-%d', strtotime(str_replace('/', '-', $request->get('data-pagamento-regcaixa')))));
            $caixa->custo_fixo = $request->custo;
            $caixa->forma_pg = $request->get('forma-pg');
            $caixa->save();
            
            if ($caixa instanceof \Exception)
            {
                $upcaixaexception = $caixa;
                $upcaixa = self::SEM_MSG_TELA;
            }
            else
            {
                $upcaixaexception = null;
                $upcaixa = $caixa;
            }
            $usuario_criador = $caixa->users->name;
            return $this->edicaoCaixa($caixa, null, $usuario_criador, $upcaixa, $upcaixaexception);
        }
        $caixaexception = ($caixa instanceof \Exception) ? $caixa : null;

        return $this->edicaoCaixa($caixa, $caixaexception, null, null, null);
    }

    public function destroy($id)
    {
        if (CaixaFacade::where('id', $id)->delete() > 0) return response(1, 200);
        return response(-1, 400);
    }
}
