<?php

namespace App\Http\Controllers;

use App\Events\FinalizouCompra;
use App\Events\CancelouCompra;
use App\Facades\CompraFacade;
use App\Facades\FornecedorFacade;
use App\Facades\ProdutoFacade;
use App\Facades\ItemCompraFacade;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    const SEM_MSG_TELA = 9;

    public function __construct()
	{
		$this->middleware('auth');
	}

	private function dashboardCompras($cadcompra, $cadcompraexception)
	{
        $compras = CompraFacade::orderBy('id', 'desc')->paginate(10);
        $listacompras = CompraFacade::listarComprasSomentePorDescricao();
        
        if ($compras instanceof \Exception) $comprasexception = $compras;
        
        return view ('erp.compra.compras', compact('compras', 'comprasexception', 'cadcompra', 'cadcompraexception', 'listacompras'));
	}

	private function mostraCompra($compra, $compraexception, $itensCompra, $cliente, $upcompra, $upcompraexception, $usuario_criador)
    {
        return view ('erp.compra.compra', compact('compra', 'compraexception', 'itensCompra', 'cliente', 'upcompra', 'upcompraexception', 'usuario_criador'));
    }

    public function index()
	{
		return $this->dashboardCompras(self::SEM_MSG_TELA, null);
	}

	public function create()
	{
		$fornecedores = FornecedorFacade::listarFornecedoresSomentePorNome();
		$produtos = ProdutoFacade::listarProdutosSomentePorDescricao();
		$fornecedor = FornecedorFacade::find(1);

		return view ('erp.compra.criarcompra', compact('fornecedores', 'produtos', 'fornecedor'));
	}

	public function store(Request $request)
    {
        //if (Auth::user()->cargo != 'admin') return back()->with('msg', 'Usuário sem permissão');
        $qtd_request = count($request->all());
        //dd(strftime('%Y-%m-%d', strtotime(str_replace('05', 'May', $request->get('data-emissao')))));
    	if ($qtd_request > 10)//8
    	{
    		$qtd_itens_enviados = ($qtd_request - 10) / 6;
            $itens = ItemCompraFacade::iteraItens($qtd_itens_enviados, $request->all());
            if ($itens == null) return back()->with('msg', 'Compra com itens vazios. Favor incluir um produto ou retirar o item');

    		$compra = CompraFacade::novaCompra();
    		$compra->id_fornecedor = $request->get('id-fornecedor');
    		$compra->id_usuario = $request->get('id-usuario');
    		$compra->total_compra = number_format((double)str_replace(',', '.', str_replace('.', '', $request->total)), 2, '.', '');
    		$compra->forma_pg_compra = $request->get('forma-pg-compra');
    		$compra->parcelas = $request->parcelas;
    		$compra->data_emissao = utf8_encode(strftime('%Y-%m-%d', strtotime(str_replace('/', '-', $request->get('data-emissao')))));
    		$compra->numero_nota = $request->get('numero-nota');
            $compra->status = 'pendente';
            $compra->vencimento = utf8_encode(strftime('%Y-%m-%d', strtotime(str_replace('/', '-', $request->vencimento))));
            $compra->restante = number_format((double)str_replace(',', '.', str_replace('.', '', $request->restante)), 2, '.', '');

    		if ($compra->save())
    			if (\Event::fire(new FinalizouCompra($compra->id, $itens))) CompraFacade::setStatusCompra($compra->id, 'finalizada');

    		$compraexception = ($compra instanceof \Exception) ? $compra : null;

    		return $this->dashboardCompras($compra, $compraexception);
    	}
    	else return back()->with('msg', 'Não pode realizar compra sem itens');
    }

    public function showPorSlug($slug)
    {
        $cliente = VendaFacade::getClientePorNome($slug);

        $clienteexception = ($cliente instanceof \Exception) ? $cliente : null;
        
        return $this->mostraVenda($cliente, $clienteexception, self::SEM_MSG_TELA, null);
    }

    public function show($id)
    {
        $compra = CompraFacade::find($id);
        $itensCompra = $compra->itensCompra;//id_produto
        $fornecedor = $compra->fornecedor;
        //$produto = ProdutoFacade::find($itensCompra->id_produto);
        //dd($compra);

        $compraexception = ($compra instanceof \Exception) ? $compra : null;
        
        return $this->mostraCompra($compra, $compraexception, $itensCompra, $fornecedor, self::SEM_MSG_TELA, null, $compra->users->name);
    }

    public function edit($id)
    {
    	$compra = CompraFacade::find($id);
        $itens = $compra->itensCompra;
        $produtos = ProdutoFacade::listarProdutosSomentePorDescricao();

    	return view ('erp.compra.editacompra', compact('compra', 'itens', 'produtos'));
    }

    public function update(Request $request, $id)
    {
        //if (Auth::user()->cargo != 'admin') return back()->with('msg', 'Usuário sem permissão');
        $compra = CompraFacade::find($id);
        
        if (!is_null($compra) & !($compra instanceof \Exception))
        {
            $qtd_request = count($request->all());
            if ($qtd_request > 10)
            {
                $qtd_itens_enviados = ($qtd_request - 10) / 6;
                $itens = ItemCompraFacade::iteraItens($qtd_itens_enviados, $request->all());
                
                if ($itens == null) return back()->with('msg', 'Compra com itens vazios. Favor incluir um produto ou retirar o item');

	    		$compra->id_usuario = $request->get('id-usuario');
	    		$compra->total_compra = number_format((double)str_replace(',', '.', str_replace('.', '', $request->total)), 2, '.', '');
	    		$compra->forma_pg_compra = $request->get('forma-pg-compra');
	    		$compra->parcelas = $request->parcelas;
	    		$compra->data_emissao = utf8_encode(strftime('%Y-%m-%d', strtotime(str_replace('/', '-', $request->get('data-emissao')))));
                $compra->numero_nota = $request->get('numero-nota');
                $compra->vencimento = utf8_encode(strftime('%Y-%m-%d', strtotime(str_replace('/', '-', $request->vencimento))));
                $compra->restante = number_format((double)str_replace(',', '.', str_replace('.', '', $request->restante)), 2, '.', '');
                
                ItemCompraFacade::excluir($id);

                if ($compra->save()) 
                    if (\Event::fire(new FinalizouCompra($compra->id, $itens))[0][0] > 0) $compra = $compra->setStatusCompra($compra->id, 'finalizada');

                $compra = CompraFacade::find($id);
                $itensCompra = $compra->itensCompra;
                $fornecedor = $compra->fornecedor;

                if ($compra instanceof \Exception)
                {
                    $upcompraexception = $compra;
                    $upcompra = self::SEM_MSG_TELA;
                    $compraexception = $compra;
                }
                else
                {
                    $upcompraexception = null;
                    $upcompra = $compra;
                    $compraexception = null;
                }

                return $this->mostraCompra($compra, $compraexception, $itensCompra, $fornecedor, $upcompra, $upcompraexception, $compra->users->name);
            }
            else return back()->with('msg', 'Não pode realizar compra sem itens');
        }
        $compraexception = ($compra instanceof \Exception) ? $compra : null;

        return $this->mostraCompra($compra, $compraexception, null, null, null, null, $compra->users->name);
    }

    public function cancelar($id)
    {
        $compra = CompraFacade::find($id);
        if ($compra->status === 'finalizada')
        {
            $compra->status = 'cancelada';
            $compra->save();
            \Event::fire(new CancelouCompra($id));
        }
        elseif ($compra->status === 'pendente') CompraFacade::setStatusCompra($id, 'cancelada');
        
        return $this->dashboardCompras(self::SEM_MSG_TELA, null);
    }

    public function detalheCompraProduto()
    {
        $produtosall = ProdutoFacade::all();
        /*$produtos = ItemCompraFacade::join('produtos', 'item_compras.id_produto', '=', 'produtos.id')
            //->select('produtos.descricao', \DB::raw('MAX(item_compras.id)'), 'item_compras.preco_compra as preco')
            ->select('produtos.descricao', 'item_compras.id_produto', \DB::raw('MAX(item_compras.id)'))
            ->groupBy('item_compras.id_produto')
            //->groupBy('produtos.descricao')
            ->get();*/
        $produtos = \DB::select('select aux.descricao, ic2.preco_compra from item_compras ic2 inner join (select id_produto, p.descricao, max(ic.id) as mid from item_compras ic inner join produtos p on ic.id_produto=p.id group by id_produto, p.descricao) aux on aux.mid=ic2.id order by 1');
        //dd($produtos);
/*        
        $compraitens = ItemCompraFacade::select('id_produto', \DB::raw('MAX(id)'), 'preco_compra as preco')
            //->where('id_produto', $id)
            ->groupBy('id_produto')
            ->get();
*/
        return view ('erp.produto.detalhecompra', compact('produtos', 'produtosall'));
    }
}
