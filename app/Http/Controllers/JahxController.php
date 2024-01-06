<?php

namespace App\Http\Controllers;

use App\Events\PreparaDadosTelaDeProdutos;
use App\Facades\MarcaFacade;
use App\Facades\UnidadeMedidaFacade;
use App\Facades\ProdutoFacade;
use App\Facades\CategoriaFacade;
use App\Facades\FormaPagamentoFacade;
use App\Facades\UsuarioFacade;
use App\Facades\ClienteFacade;
use App\Facades\CustoFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GClient;
use GuzzleHttp\Psr7\Request as GRequest;

class JahxController extends Controller
{
	const SEM_MSG_TELA = 9;

    public function __construct()
	{
		$this->middleware('auth');
	}

    public function inicial(){
    	$clientes = ClienteFacade::select('nome_rsocial')->get();
        $produtos = ProdutoFacade::select('descricao')->get();
        return view ('pdvweb.jahxpdv', compact('clientes', 'produtos'));
    }

    //funcoes dashboard
    public function dashboard()
    {
    	return view ('erp.dashboard');
    }

    public function listProdutos()
    {
        return $this->dashboardProdutos(self::SEM_MSG_TELA, null);

        $dados = \Event::fire(new PreparaDadosTelaDeProdutos());
        //dd($dados[0][1]);
        $marcas = $dados[0][0];
        $unmedidas = $dados[0][1];
        $categorias = $dados[0][2];
        $marcasexception = $dados[0][3];
        $unmedidasexception = $dados[0][4];
        $categoriasexception = $dados[0][5];
        
        $produtos = ProdutoFacade::listarProduto();
        if ($produtos instanceof \Exception) $produtosexception = $produtos;

        return view ('erp.produto.produtos', compact('marcas', 'unmedidas', 'categorias', 'produtos', 'marcasexception', 'unmedidasexception', 'categoriasexception', 'produtosexception'));


        $marcas = MarcaFacade::listMarca();
    	$unmedidas = UnidadeMedidaFacade::listUnidadeMedida();
        $categorias = CategoriaFacade::listaCategoria();
    	$produtos = ProdutoFacade::listarProduto();
        //code p sistema interno
        
        if ($marcas instanceof \Exception) $marcasexception = $marcas;
        if ($unmedidas instanceof \Exception) $unmedidasexception = $unmedidas;
        if ($categorias instanceof \Exception) $categoriasexception = $categorias;
        if ($produtos instanceof \Exception) $produtosexception = $produtos;
        //dd($marcas);
        return view ('erp.produto.produtos', compact('marcas', 'unmedidas', 'categorias', 'produtos', 'marcasexception', 'unmedidasexception', 'categoriasexception', 'produtosexception'));
        //if ($produtos == null)
        //{
        //    view ('erp.produtos', compact('marcas', 'unmedidas', 'categorias', 'produtos'));
        //}
        //return 
        //fim code
        
        //code p api
        //if ($produtos->status() == 200)
        //{
        //    $produtos = json_decode($produtos->content());
        //    return view ('erp.produtos', compact('marcas', 'unmedidas', 'categorias', 'produtos'));
        //}
        //fim code
    }
    
    public function listClientes()
    {
    	return view ('erp.cliente.clientes');
    }

    public function listAjustes()
    {
    	return view ('erp.ajustes');
    }

    //funcoes cliente
    public function createCliente(Request $request)
    {
    	dd(\Request::all());
    }

    //funcoes fornecedor

    //funcoes produtos
    public function createProduto(Request $request)
    {
        //if (Auth::user()->cargo != 'admin') return back()->with('msg', 'Usuário sem permissão');
        $produto = ProdutoFacade::novoProduto();
        $produto->fill($request->all());
        $produto->id_categoria = $request->get('id-categoria');
        $produto->unidade_medida = $request->get('un');
        $produto->preco_venda = number_format((double)str_replace(',', '.', str_replace('.', '', $request->get('preco-venda'))), 2, '.', '');
        $produto->qtd_minima = $request->get('qtd-minima');

        $produto = ProdutoFacade::cadastrarProduto($produto);

        $produtosexception = ($produto instanceof \Exception) ? $produto : null;

        return $this->dashboardProdutos($produto, $produtosexception);
    }

    private function dashboardProdutos($cadprod, $cadprodexception)
    {
        //Log::info('usuario:', ['id' => Auth::user()->id, 'metodo' => 'listar produtos']);
        $marcas = MarcaFacade::listarMarca();
        $unmedidas = UnidadeMedidaFacade::listarUnidadeMedida();
        $categorias = CategoriaFacade::listarCategoria();
        $produtos = ProdutoFacade::orderBy('descricao')->paginate(10);
        $produtosall = ProdutoFacade::all();
        
        if ($marcas instanceof \Exception) $marcasexception = $marcas;
        if ($unmedidas instanceof \Exception) $unmedidasexception = $unmedidas;
        if ($categorias instanceof \Exception) $categoriasexception = $categorias;
        if ($produtos instanceof \Exception) $produtosexception = $produtos;
        //dd($marcasexception);
        return view ('erp.produto.produtos', compact('marcas', 'unmedidas', 'categorias', 'produtos', 'marcasexception', 'unmedidasexception', 'categoriasexception', 'produtosexception', 'cadprod', 'cadprodexception', 'produtosall'));
    }

    public function showDescricaoProduto($slug)
    {
        $produto = ProdutoFacade::getProdutoPorDescricao($slug);

        $produtoexception = ($produto instanceof \Exception) ? $produto : null;
        
        return $this->edicaoProduto($produto, $produtoexception, self::SEM_MSG_TELA, null);
    }

    public function showProduto($id)
    {
        $produto = ProdutoFacade::getProduto($id);

        $produtoexception = ($produto instanceof \Exception) ? $produto : null;
        
        return $this->edicaoProduto($produto, $produtoexception, self::SEM_MSG_TELA, null);
    }

    private function edicaoProduto($produto, $produtoexception, $upprod, $upprodexception)
    {
        $marcas = MarcaFacade::listarMarca();
        $unmedidas = UnidadeMedidaFacade::listarUnidadeMedida();
        $categorias = CategoriaFacade::listarCategoria();
        
        
        if ($marcas instanceof \Exception) $marcasexception = $marcas;
        if ($unmedidas instanceof \Exception) $unmedidasexception = $unmedidas;
        if ($categorias instanceof \Exception) $categoriasexception = $categorias;

        return view ('erp.produto.editaproduto', compact('marcas', 'unmedidas', 'categorias', 'produto', 'marcasexception', 'unmedidasexception', 'categoriasexception', 'produtoexception', 'upprod', 'upprodexception'));
    }

    public function updateProduto(Request $request, $id)
    {
        $produto = ProdutoFacade::getProduto($id);
        
        if (!is_null($produto) & !($produto instanceof \Exception))
        {
            $produto->fill($request->all());
            $produto->id_categoria = $request->get('id-categoria');
            $produto->unidade_medida = $request->un;
            $produto->preco_venda = number_format((double)str_replace(',', '.', str_replace('.', '', $request->get('preco-venda'))), 2, '.', '');
            $produto->qtd_minima = $request->get('qtd-minima');
            
            $produto = ProdutoFacade::atualizaProduto($produto);
            if ($produto instanceof \Exception)
            {
                $upprodexception = $produto;
                $upprod = self::SEM_MSG_TELA;
            }
            else
            {
                $upprodexception = null;
                $upprod = $produto;
            }

            return $this->edicaoProduto($produto, null, $upprod, $upprodexception);
        }
        $produtoexception = ($produto instanceof \Exception) ? $produto : null;

        return $this->edicaoProduto($produto, $produtoexception, null, null);
    }

    //funcoes usuario
    public function getUsuario()
    {
    	return view ('erp.usuario');
    }

    //funcoes ajustes
    public function listMarcas()
    {
        return $this->dashboardMarcas(self::SEM_MSG_TELA, null);
    }

    public function listUnidadeMedidas()
    {
        return $this->dashboardUnidadeMedidas(self::SEM_MSG_TELA, null);
    }

    public function listFormaPagamentos()
    {
        return $this->dashboardFormaPagamentos(self::SEM_MSG_TELA, null);
    }

    public function listCategorias()
    {
        return $this->dashboardCategorias(self::SEM_MSG_TELA, null);
    }

    public function listUsuarios()
    {
        return $this->dashboardUsuarios(self::SEM_MSG_TELA, null);
    }

    public function listCustos()
    {
        return $this->dashboardCustos(self::SEM_MSG_TELA, null);
    }

    //funcoes marcas
    public function createMarca(Request $request)
    {
        //if (Auth::user()->cargo != 'admin') return back();
        $marca = MarcaFacade::novaMarca();
        $marca->nome_marca = $request->get('nome-marca');

        $marca = MarcaFacade::cadastrarMarca($marca);

        $marcasexception = ($marca instanceof \Exception) ? $marca : null;

        return $this->dashboardMarcas($marca, $marcasexception);
    }

    private function dashboardMarcas($cadmarca, $cadmarcaexception)
    {
        $marcas = MarcaFacade::orderBy('nome_marca')->paginate(10);
        $marcasall = MarcaFacade::all();

        if ($marcas instanceof \Exception) $marcasexception = $marcas;

        return view ('erp.ajuste.marca.marcas', compact('marcas', 'marcasexception', 'cadmarca', 'cadmarcaexception', 'marcasall'));
    }

    public function showNomeMarca($slug)
    {
        $marca = MarcaFacade::getMarcaPorNome($slug);

        $marcaexception = ($marca instanceof \Exception) ? $marca : null;
        
        return $this->edicaoMarca($marca, $marcaexception, self::SEM_MSG_TELA, null);
    }

    public function showMarca($id)
    {
        $marca = MarcaFacade::getMarca($id);

        $marcaexception = ($marca instanceof \Exception) ? $marca : null;
        
        return $this->edicaoMarca($marca, $marcaexception, self::SEM_MSG_TELA, null);
    }

    public function updateMarca(Request $request, $id)
    {
        $marca = MarcaFacade::getMarca($id);
        
        if (!is_null($marca) & !($marca instanceof \Exception))
        {
            $marca->nome_marca = $request->get('nome-marca');
            
            $marca = MarcaFacade::atualizaMarca($marca);
            if ($marca instanceof \Exception)
            {
                $upmarcaexception = $marca;
                $upmarca = self::SEM_MSG_TELA;
            }
            else
            {
                $upmarcaexception = null;
                $upmarca = $marca;
            }

            return $this->edicaoMarca($marca, null, $upmarca, $upmarcaexception);
        }
        $marcaexception = ($marca instanceof \Exception) ? $marca : null;

        return $this->edicaoMarca($marca, $marcaexception, null, null);
    }

    private function edicaoMarca($marca, $marcaexception, $upmarca, $upmarcaexception)
    {

        return view ('erp.ajuste.marca.editamarca', compact('marca', 'marcaexception', 'upmarca', 'upmarcaexception'));
    }

    //funcoes unidades de medidas
    public function createUnidadeMedida(Request $request)
    {
        //if (Auth::user()->cargo != 'admin') return back();
        $unmedida = UnidadeMedidaFacade::novaUnidadeMedida();
        $unmedida->fill($request->all());

        $unmedida = UnidadeMedidaFacade::cadastrarUnidadeMedida($unmedida);

        $unmedidasexception = ($unmedida instanceof \Exception) ? $unmedida : null;

        return $this->dashboardUnidadeMedidas($unmedida, $unmedidasexception);
    }

    private function dashboardUnidadeMedidas($cadunmedida, $cadunmedidaexception)
    {
        $unmedidas = UnidadeMedidaFacade::orderBy('descricao')->paginate(10);
        $unmedidasall = UnidadeMedidaFacade::all();

        if ($unmedidas instanceof \Exception) $unmedidasexception = $unmedidas;

        return view ('erp.ajuste.unidademedida.unidadesmedidas', compact('unmedidas', 'unmedidasexception', 'cadunmedida', 'cadunmedidaexception', 'unmedidasall'));
    }

    public function showDescricaoUnidadeMedida($slug)
    {
        $unmedida = UnidadeMedidaFacade::getUnidadeMedidaPorDescricao($slug);

        $unmedidaexception = ($unmedida instanceof \Exception) ? $unmedida : null;
        
        return $this->edicaoUnidadeMedida($unmedida, $unmedidaexception, self::SEM_MSG_TELA, null);
    }

    public function showUnidadeMedida($id)
    {
        $unmedida = UnidadeMedidaFacade::getUnidadeMedida($id);

        $unmedidaexception = ($unmedida instanceof \Exception) ? $unmedida : null;
        
        return $this->edicaoUnidadeMedida($unmedida, $unmedidaexception, self::SEM_MSG_TELA, null);
    }

    public function updateUnidadeMedida(Request $request, $id)
    {
        $unmedida = UnidadeMedidaFacade::getUnidadeMedida($id);
        
        if (!is_null($unmedida) & !($unmedida instanceof \Exception))
        {
            $unmedida->fill($request->all());
            
            $unmedida = UnidadeMedidaFacade::atualizaUnidadeMedida($unmedida);
            if ($unmedida instanceof \Exception)
            {
                $upunmedidaexception = $unmedida;
                $upunmedida = self::SEM_MSG_TELA;
            }
            else
            {
                $upunmedidaexception = null;
                $upunmedida = $unmedida;
            }

            return $this->edicaoUnidadeMedida($unmedida, null, $upunmedida, $upunmedidaexception);
        }
        $unmedidaexception = ($unmedida instanceof \Exception) ? $unmedida : null;

        return $this->edicaoUnidadeMedida($unmedida, $unmedidaexception, null, null);
    }

    private function edicaoUnidadeMedida($unmedida, $unmedidaexception, $upunmedida, $upunmedidaexception)
    {

        return view ('erp.ajuste.unidademedida.editaunidademedida', compact('unmedida', 'unmedidaexception', 'upunmedida', 'upunmedidaexception'));
    }

    //funcoes forma de pagamentos
    public function createFormaPagamento(Request $request)
    {
        //if (Auth::user()->cargo != 'admin') return back();
        $formapag = FormaPagamentoFacade::novaFormaPagamento();
        $formapag->fill($request->all());

        $formapag = FormaPagamentoFacade::cadastrarFormaPagamento($formapag);

        $formapagsexception = ($formapag instanceof \Exception) ? $formapag : null;

        return $this->dashboardFormaPagamentos($formapag, $formapagsexception);
    }

    private function dashboardFormaPagamentos($cadformapag, $cadformapagexception)
    {
        $formapags = FormaPagamentoFacade::orderBy('forma')->paginate(10);
        $formapagsall = FormaPagamentoFacade::all();

        if ($formapags instanceof \Exception) $formapagsexception = $formapags;

        return view ('erp.ajuste.formapagamento.formapagamentos', compact('formapags', 'formapagsexception', 'cadformapag', 'cadformapagexception', 'formapagsall'));
    }

    public function showFormaFormaPagamento($slug)
    {
        $formapag = FormaPagamentoFacade::getFormaPagamentoPorForma($slug);

        $formapagexception = ($formapag instanceof \Exception) ? $formapag : null;
        
        return $this->edicaoFormaPagamento($formapag, $formapagexception, self::SEM_MSG_TELA, null);
    }

    public function showFormaPagamento($id)
    {
        $formapag = FormaPagamentoFacade::getFormaPagamento($id);

        $formapagexception = ($formapag instanceof \Exception) ? $formapag : null;
        
        return $this->edicaoFormaPagamento($formapag, $formapagexception, self::SEM_MSG_TELA, null);
    }

    public function updateFormaPagamento(Request $request, $id)
    {
        $formapag = FormaPagamentoFacade::getFormaPagamento($id);
        
        if (!is_null($formapag) & !($formapag instanceof \Exception))
        {
            $formapag->fill($request->all());
            
            $formapag = FormaPagamentoFacade::atualizaFormaPagamento($formapag);
            if ($formapag instanceof \Exception)
            {
                $upformapagexception = $formapag;
                $upformapag = self::SEM_MSG_TELA;
            }
            else
            {
                $upformapagexception = null;
                $upformapag = $formapag;
            }

            return $this->edicaoFormaPagamento($formapag, null, $upformapag, $upformapagexception);
        }
        $formapagexception = ($formapag instanceof \Exception) ? $formapag : null;

        return $this->edicaoFormaPagamento($formapag, $formapagexception, null, null);
    }

    private function edicaoFormaPagamento($formapag, $formapagexception, $upformapag, $upformapagexception)
    {

        return view ('erp.ajuste.formapagamento.editaformapagamento', compact('formapag', 'formapagexception', 'upformapag', 'upformapagexception'));
    }

    //funcoes categorias
    public function createCategoria(Request $request)
    {
        //if (Auth::user()->cargo != 'admin') return back();
        $categoria = CategoriaFacade::novaCategoria();
        $categoria->nome_categoria = $request->get('nome-categoria');

        $categoria = CategoriaFacade::cadastrarCategoria($categoria);

        $categoriasexception = ($categoria instanceof \Exception) ? $categoria : null;

        return $this->dashboardCategorias($categoria, $categoriasexception);
    }

    private function dashboardCategorias($cadcategoria, $cadcategoriaexception)
    {
        $categorias = CategoriaFacade::orderby('nome_categoria')->paginate(10);
        $categoriasall = CategoriaFacade::all();

        if ($categorias instanceof \Exception) $categoriasexception = $categorias;

        return view ('erp.ajuste.categoria.categorias', compact('categorias', 'categoriasexception', 'cadcategoria', 'cadcategoriaexception', 'categoriasall'));
    }

    public function showNomeCategoria($slug)
    {
        $categoria = CategoriaFacade::getCategoriaPorNome($slug);

        $categoriaexception = ($categoria instanceof \Exception) ? $categoria : null;
        
        return $this->edicaoCategoria($categoria, $categoriaexception, self::SEM_MSG_TELA, null);
    }

    public function showCategoria($id)
    {
        $categoria = CategoriaFacade::getCategoria($id);

        $categoriaexception = ($categoria instanceof \Exception) ? $categoria : null;
        
        return $this->edicaoCategoria($categoria, $categoriaexception, self::SEM_MSG_TELA, null);
    }

    public function updateCategoria(Request $request, $id)
    {
        $categoria = CategoriaFacade::getCategoria($id);
        
        if (!is_null($categoria) & !($categoria instanceof \Exception))
        {
            $categoria->nome_categoria = $request->get('nome-categoria');
            
            $categoria = CategoriaFacade::atualizaCategoria($categoria);
            if ($categoria instanceof \Exception)
            {
                $upcategoriaexception = $categoria;
                $upcategoria = self::SEM_MSG_TELA;
            }
            else
            {
                $upcategoriaexception = null;
                $upcategoria = $categoria;
            }

            return $this->edicaoCategoria($categoria, null, $upcategoria, $upcategoriaexception);
        }
        $categoriaexception = ($categoria instanceof \Exception) ? $categoria : null;

        return $this->edicaoCategoria($categoria, $categoriaexception, null, null);
    }

    private function edicaoCategoria($categoria, $categoriaexception, $upcategoria, $upcategoriaexception)
    {

        return view ('erp.ajuste.categoria.editacategoria', compact('categoria', 'categoriaexception', 'upcategoria', 'upcategoriaexception'));
    }

    //funcoes usuarios
    public function createUsuario(Request $request)
    {
        //if (Auth::user()->cargo != 'admin') return back();
        $user = new \App\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->cargo = $request->cargo;
        $user->save();
        
        $cadusuarioexception = ($user instanceof \Exception) ? $user : null;

        return $this->dashboardUsuarios($user, $cadusuarioexception);
    }

    private function dashboardUsuarios($cadusuario, $cadusuarioexception)
    {
        $usuarios = \App\User::listarUsuarioPaginado(10);

        if ($usuarios instanceof \Exception) $usuariosexception = $usuarios;

        return view ('erp.ajuste.usuario.usuarios', compact('usuarios', 'usuariosexception', 'cadusuario', 'cadusuarioexception'));
    }

    public function showNomeUsuario($slug)
    {
        $usuario = \App\User::getUsuarioPorNome($slug);

        $usuarioexception = ($usuario instanceof \Exception) ? $usuario : null;
        
        return $this->edicaoUsuario($usuario, $usuarioexception, self::SEM_MSG_TELA, null);
    }

    public function showUsuario($id)
    {
        $usuario = \App\User::find($id);

        $usuarioexception = ($usuario instanceof \Exception) ? $usuario : null;
        
        return $this->edicaoUsuario($usuario, $usuarioexception, self::SEM_MSG_TELA, null);
    }

    public function updateUsuario(Request $request, $id)
    {
        $usuario = \App\User::find($id);
        
        if (!is_null($usuario) & !($usuario instanceof \Exception))
        {
            $usuario->fill($request->all());
            
            $usuario->save();
            
            if ($usuario instanceof \Exception)
            {
                $upusuarioexception = $usuario;
                $upusuario = self::SEM_MSG_TELA;
            }
            else
            {
                $upusuarioexception = null;
                $upusuario = $usuario;
            }

            return $this->edicaoUsuario($usuario, null, $upusuario, $upusuarioexception);
        }
        $usuarioexception = ($usuario instanceof \Exception) ? $usuario : null;

        return $this->edicaoUsuario($usuario, $usuarioexception, null, null);
    }

    private function edicaoUsuario($usuario, $usuarioexception, $upusuario, $upusuarioexception)
    {

        return view ('erp.ajuste.usuario.editausuario', compact('usuario', 'usuarioexception', 'upusuario', 'upusuarioexception'));
    }

    public function showPermissaoUsuario($id)
    {
        $usuario = \App\User::find($id);

        $usuarioexception = ($usuario instanceof \Exception) ? $usuario : null;
        
        return $this->edicaoPermissaoUsuario($usuario, $usuarioexception, self::SEM_MSG_TELA, null, $usuario->permissions);
    }

    private function edicaoPermissaoUsuario($usuario, $usuarioexception, $upusuario, $upusuarioexception, $permissoes_usuario)
    {
        $permissoes = \App\Permission::all();
        return view ('erp.ajuste.usuario.editapermissaousuario', compact('usuario', 'usuarioexception', 'upusuario', 'upusuarioexception', 'permissoes', 'permissoes_usuario'));
    }

    public function alterPermissaoUsuario(Request $request, $id)
    {
        //dd($request->all());
        $usuario = \App\User::find($id);
        $permissao = $usuario->permissions;
        $permissoes = \App\Permission::all();

        $perm_array = $permissao->toArray();
        $array_linear_permissao_do_usuario = [];
        foreach ($perm_array as $teste)
        {
            $array_linear_permissao_do_usuario[] = $teste['cod_funcao'];
        }
        
        //dd($array_linear_permissao_do_usuario);
        foreach ($permissoes as $ps)
        {
            if ($request->has($ps->cod_funcao))
            {
                if (empty($perm_array)) 
                    $usuario->permissions()->attach($ps->id);
                else {
                    if (!in_array($ps->cod_funcao, $array_linear_permissao_do_usuario)) 
                        $usuario->permissions()->attach($ps->id);
                }
            }
        }
        foreach ($permissao as $pu)
        {
            if (!$request->has($pu->cod_funcao)) $usuario->permissions()->detach($pu->id);
        }

        $usuarioexception = ($usuario instanceof \Exception) ? $usuario : null;
        
        return $this->edicaoPermissaoUsuario($usuario, $usuarioexception, $usuario, null, \App\User::find($id)->permissions);
    }

    public function updateMyUser(Request $request, $id)
    {
        $user = \App\User::find($id);
        if (is_null($user)) return back()->with('msg', 'Usuário não cadastrado');
        $user->name = $request->name;
        $user->email = $request->email;
        $aviso = 'Houve um erro na alteração!';
        if ($user->save())
        {
            Auth::user()->name = $user->name;
            Auth::user()->email = $user->email;
            $aviso = 'Dados alterados!';
        }
        $userexception = ($user instanceof \Exception) ? $user : null;

        return view ('erp.usuario', compact('aviso', 'userexception'));
    }

    //rotas pdv
    public function listarNomeClientesPDV()
    {
        $clientes = CliendeFacade::select('nome_rsocial')->get();
        return view ('');
    }

    //rotas relatorios
    public function listRelatorios()
    {
        return view ('erp.relatorio.relatorios');
    }

    //rotas custos
    public function createCusto(Request $request)
    {
        $custo = CustoFacade::novoCusto();
        $custo->custo = $request->custo;
        $custo->usuario_id = $request->get('usuario-id');

        $custo->save();

        $custosexception = ($custo instanceof \Exception) ? $custo : null;

        return $this->dashboardCustos($custo, $custosexception);
    }

    private function dashboardCustos($cadcusto, $cadcustoexception)
    {
        $custos = CustoFacade::orderby('custo')->paginate(10);
        $custosall = CustoFacade::all();

        if ($custos instanceof \Exception) $custosexception = $custos;

        return view ('erp.ajuste.custo.custos', compact('custos', 'custosexception', 'cadcusto', 'cadcustoexception', 'custosall'));
    }

    public function showNomeCusto($slug)
    {
        $custo = CustoFacade::where('custo', $slug)->first();

        $custoexception = ($custo instanceof \Exception) ? $custo : null;
        
        return $this->edicaoCusto($custo, $custoexception, self::SEM_MSG_TELA, null);
    }

    public function showCusto($id)
    {
        $custo = CustoFacade::find($id);

        $custoexception = ($custo instanceof \Exception) ? $custo : null;
        
        return $this->edicaoCusto($custo, $custoexception, self::SEM_MSG_TELA, null);
    }

    public function updateCusto(Request $request, $id)
    {
        $custo = CustoFacade::find($id);
        
        if (!is_null($custo) & !($custo instanceof \Exception))
        {
            $custo->custo = $request->custo;
            
            $custo->save();
            if ($custo instanceof \Exception)
            {
                $upcustoexception = $custo;
                $upcusto = self::SEM_MSG_TELA;
            }
            else
            {
                $upcustoexception = null;
                $upcusto = $custo;
            }

            return $this->edicaoCusto($custo, null, $upcusto, $upcustoexception);
        }
        $custoexception = ($custo instanceof \Exception) ? $custo : null;

        return $this->edicaoCusto($custo, $custoexception, null, null);
    }

    private function edicaoCusto($custo, $custoexception, $upcusto, $upcustoexception)
    {

        return view ('erp.ajuste.custo.editacusto', compact('custo', 'custoexception', 'upcusto', 'upcustoexception'));
    }

    public function destroyCusto($id)
    {
        return CustoFacade::where('id', $id)->delete();
    }
}