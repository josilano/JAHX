<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use App\Facades\VendaFacade;
use App\Facades\ItemVendaFacade;
use App\Events\FinalizouVenda;
use App\Events\VendaDinheiroECartao;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class APIVendaController extends Controller
{
    public function apiVendas(Request $request)
    {
        try{
            if ($user = JWTAuth::parseToken()->authenticate())
            {
                //executa a venda
                //return $request->all();
                $itens = [];
                $venda = VendaFacade::novaVenda();
                $venda->id_cliente = $request->cliente_id;
                $venda->id_usuario = $request->user_id;
                $venda->total_venda = number_format((double)str_replace(',', '.', str_replace('.', '', $request->total_venda)), 2, '.', '');
                $venda->desconto = $request->desconto;
                $venda->forma_pg_venda = $request->forma_pagamento;
                $venda->parcelas = $request->parcelas;
                $venda->total_itens = number_format((double)str_replace(',', '.', str_replace('.', '', $request->total_itens)), 2, '.', '');
                $venda->tipo_desconto = $request->tipo_desconto;
                $venda->status = 'pendente';
                $venda->dinheiro = number_format((double)str_replace(',', '.', str_replace('.', '', $request->dinheiro)), 2, '.', '');
                $venda->troco = number_format((double)str_replace(',', '.', str_replace('.', '', $request->troco)), 2, '.', '');
                $venda->observacoes = $request->observacoes;
                $venda->setor_venda = $request->setor_venda;
                $venda->restante = number_format((double)str_replace(',', '.', str_replace('.', '', $request->restante)), 2, '.', '');
                //return $venda;
                //return $itens[1]['descricao_produto'];
                foreach($request->itens_venda as $item)
                {
                    $itemVenda = ItemVendaFacade::novoItemVenda();
                    $itemVenda->descricao_produto = $item['descricao_produto'];
                    $itemVenda->ean_produto = $item['ean_produto'];
                    $itemVenda->un_produto = $item['un_produto'];
                    $itemVenda->qtd_venda = number_format((double)str_replace(',', '.', $item['qtd_produto']), 3, '.', '');
                    $itemVenda->preco_vendido = number_format((double)str_replace(',', '.', str_replace('.', '', $item['preco_venda'])), 2, '.', '');
                    $itemVenda->subtotal = number_format((double)str_replace(',', '.', str_replace('.', '', $item['total_item'])), 2, '.', '');
                    array_push($itens,  $itemVenda);
                }

                if ($venda->save())
                    if (\Event::fire(new FinalizouVenda($venda->id, $itens))) $venda = VendaFacade::setStatusVenda($venda->id, 'finalizada');
                if ($venda->forma_pg_venda == 'DINHEIRO+CARTAO') 
                {
                    $registra_livro_caixa_suprimento = \Event::fire(new VendaDinheiroECartao($venda->id, $request->valor_cartao, $venda->id_usuario));
                    if ($registra_livro_caixa_suprimento[0]->wasRecentlyCreated) 
                    {    
                        $venda->observacoes = 'Suprimento '.$registra_livro_caixa_suprimento[0]->id.'. '.$venda->observacoes;
                        $venda->save();
                    }
                    else $venda = VendaFacade::setStatusVenda($venda->id, 'pendente');
                }
                    
                return response()->json($venda, 201);
                //return response()->json($venda, 200);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
		    return response()->json(['token_expired'], $e->getStatusCode());
	    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
		    return response()->json(['token_invalid'], $e->getStatusCode());
	    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
		    return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(['error' => 'invalid_token'], 401);
    }
}
