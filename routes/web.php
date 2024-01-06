<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//use App\Http\Middleware\CheckPermission;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['as' => 'jahxpdv.', 'prefix' => 'pdv'], function(){
	Route::get('', ['as' => 'inicial', 'uses' => 'JahxController@inicial']);
});

Route::group(['as' => 'jahx.', 'prefix' => 'erp'], function(){
	//rotas dashboard
	Route::get('', ['as' => 'dashboard', 'uses' => 'JahxController@dashboard']);
	Route::get('produtos', ['as' => 'produtos', 'uses' => 'JahxController@listProdutos']);
	Route::get('clientes', ['as' => 'clientes', 'uses' => 'ClienteController@listClientes']);
	Route::get('fornecedores', ['as' => 'fornecedores', 'uses' => 'FornecedorController@listFornecedores']);
	Route::get('ajustes', ['as' => 'ajustes', 'uses' => 'JahxController@listAjustes']);
	Route::get('vendas', ['as' => 'vendas', 'uses' => 'VendaController@index']);
	Route::get('compras', ['as' => 'compras', 'uses' => 'CompraController@index']);
	Route::get('estoque', ['as' => 'estoque', 'uses' => 'ProdutoController@showEstoque']);
	Route::get('davs', ['as' => 'davs', 'uses' => 'DAVController@index']);
	Route::get('relatorios', ['as' => 'relatorios', 'uses' => 'JahxController@listRelatorios']);
	Route::get('contas-a-pagar', ['as' => 'apagar', 'uses' => 'ContaController@listAPagar'])
	->middleware('permission:vercontapg');
	Route::get('contas-a-receber', ['as' => 'areceber', 'uses' => 'ContaController@listAReceber'])
	->middleware('permission:vercontarcb');
	Route::get('balanco-mensal', ['as' => 'balanco', 'uses' => 'BalancoController@index'])->middleware('permission:caduser');

	//rotas cliente
	Route::post('clientes', ['as' => 'addcliente', 'uses' => 'ClienteController@createCliente'])
	->middleware('permission:cadcli');
	Route::get('clientes/q={slug}', ['as' => 'mostraclientenome', 'uses' => 'ClienteController@showNomeCliente']);
	Route::get('clientes/{id}', ['as' => 'mostracliente', 'uses' => 'ClienteController@showCliente']);
	Route::put('clientes/{id}', ['as' => 'atualizacliente', 'uses' => 'ClienteController@updateCliente'])
	->middleware('permission:editcli');
	Route::get('clientes/nome/{slug}', ['as' => 'pegacliente', 'uses' => 'ClienteController@getCliente']);
	Route::get('clientes/contato/telefones', ['as' => 'telclientes', 'uses' => 'ClienteController@listaClientesTelefones']);

	//rotas fornecedor
	Route::post('fornecedores', ['as' => 'addfornecedor', 'uses' => 'FornecedorController@createFornecedor'])
	->middleware('permission:cadforncd');
	Route::get('fornecedores/q={slug}', ['as' => 'mostrafornecedornome', 'uses' => 'FornecedorController@showNomeFornecedor']);
	Route::get('fornecedores/{id}', ['as' => 'mostrafornecedor', 'uses' => 'FornecedorController@showFornecedor']);
	Route::put('fornecedores/{id}', ['as' => 'atualizafornecedor', 'uses' => 'FornecedorController@updateFornecedor'])
	->middleware('permission:editforncd');
	Route::get('fornecedores/nome/{slug}', ['as' => 'pegafornecedor', 'uses' => 'FornecedorController@getFornecedor']);

	//rotas usuario
		//my user
	Route::get('usuario', ['as' => 'usuario', 'uses' => 'JahxController@getUsuario']);
	Route::put('usuarios/{id}', ['as' => 'atualizameuusuario', 'uses' => 'JahxController@updateMyUser']);
		//manage user system
	Route::post('ajustes/usuarios', ['as' => 'addusuario', 'uses' => 'JahxController@createUsuario'])
	->middleware('permission:caduser');
	Route::get('ajustes/usuarios/q={slug}', ['as' => 'mostrausuarionome', 'uses' => 'JahxController@showNomeUsuario']);
	Route::get('ajustes/usuarios/{id}', ['as' => 'mostrausuario', 'uses' => 'JahxController@showUsuario']);
	Route::put('ajustes/usuarios/{id}', ['as' => 'atualizausuario', 'uses' => 'JahxController@updateUsuario'])
	->middleware('permission:edituser');
	Route::get('ajustes/usuarios/{id}/permissoes', ['as' => 'permissaousuario', 'uses' => 'JahxController@showPermissaoUsuario']);
	Route::post('ajustes/usuarios/{id}/permissoes', ['as' => 'alterapermissaousuario', 'uses' => 'JahxController@alterPermissaoUsuario'])
	->middleware('permission:editpermuser');
	
	//rotas produtos
	Route::post('produtos', ['as' => 'addproduto', 'uses' => 'JahxController@createProduto'])
	->middleware('permission:cadprod');
	Route::get('produtos/q={slug}', ['as' => 'mostraprodutodescricao', 'uses' => 'JahxController@showDescricaoProduto']);
	Route::get('produtos/{id}', ['as' => 'mostraproduto', 'uses' => 'JahxController@showProduto']);
	Route::put('produtos/{id}', ['as' => 'atualizaproduto', 'uses' => 'JahxController@updateProduto'])
	->middleware('permission:editprod');
	Route::get('produtos/descricao/{slug}', ['as' => 'pegaproduto', 'uses' => 'ProdutoController@getProduto']);
	Route::get('produtos/cod-barras/{slug}', ['as' => 'pegaproduto', 'uses' => 'ProdutoController@getProdutoPorEan']);
	Route::delete('produtos/{id}', ['as' => 'deletaproduto', 'uses' => 'ProdutoController@destroy'])
	->middleware('permission:remprod');
	Route::get('produtos/detalhe/compra', ['as' => 'detalheproduto', 'uses' => 'CompraController@detalheCompraProduto'])
	->middleware('permission:remprod');//permissao de remocao tem permissao de ver detalhes de compra

	//rotas estoque
	Route::get('estoque/descricao/{slug}', ['as' => 'getprodutodescricao', 'uses' => 'ProdutoController@getProdutoEstoquePorDescricao']);	

	//rotas ajustes
	Route::get('ajustes/marcas', ['as' => 'marcas', 'uses' => 'JahxController@listMarcas']);
	Route::get('ajustes/unidademedidas', ['as' => 'unmedidas', 'uses' => 'JahxController@listUnidadeMedidas']);
	Route::get('ajustes/formapagamentos', ['as' => 'formapagamentos', 'uses' => 'JahxController@listFormaPagamentos']);
	Route::get('ajustes/categorias', ['as' => 'categorias', 'uses' => 'JahxController@listCategorias']);
	Route::get('ajustes/usuarios', ['as' => 'usuarios', 'uses' => 'JahxController@listUsuarios'])
	->middleware('permission:listuser');
	Route::get('ajustes/custos', ['as' => 'custos', 'uses' => 'JahxController@listCustos']);

	//rotas marcas
	Route::post('ajustes/marcas', ['as' => 'addmarca', 'uses' => 'JahxController@createMarca'])
	->middleware('permission:cadmarca');
	Route::get('ajustes/marcas/q={slug}', ['as' => 'mostramarcanome', 'uses' => 'JahxController@showNomeMarca']);
	Route::get('ajustes/marcas/{id}', ['as' => 'mostramarca', 'uses' => 'JahxController@showMarca']);
	Route::put('ajustes/marcas/{id}', ['as' => 'atualizamarca', 'uses' => 'JahxController@updateMarca'])
	->middleware('permission:editmarca');

	//rotas unidades de medidas
	Route::post('ajustes/unidademedidas', ['as' => 'addunmedida', 'uses' => 'JahxController@createUnidadeMedida'])
	->middleware('permission:cadun');
	Route::get('ajustes/unidademedidas/q={slug}', ['as' => 'mostraunmedidadescricao', 'uses' => 'JahxController@showDescricaoUnidadeMedida']);
	Route::get('ajustes/unidademedidas/{id}', ['as' => 'mostraunmedida', 'uses' => 'JahxController@showUnidadeMedida']);
	Route::put('ajustes/unidademedidas/{id}', ['as' => 'atualizaunmedida', 'uses' => 'JahxController@updateUnidadeMedida'])
	->middleware('permission:editun');

	//rotas forma de pagamentos
	Route::post('ajustes/formapagamentos', ['as' => 'addformapag', 'uses' => 'JahxController@createFormaPagamento'])
	->middleware('permission:cadformpg');
	Route::get('ajustes/formapagamentos/q={slug}', ['as' => 'mostraformapagforma', 'uses' => 'JahxController@showFormaFormaPagamento']);
	Route::get('ajustes/formapagamentos/{id}', ['as' => 'mostraformapag', 'uses' => 'JahxController@showFormaPagamento']);
	Route::put('ajustes/formapagamentos/{id}', ['as' => 'atualizaformapag', 'uses' => 'JahxController@updateFormaPagamento'])
	->middleware('permission:editformpg');

	//rotas categorias
	Route::post('ajustes/categorias', ['as' => 'addcategoria', 'uses' => 'JahxController@createCategoria'])
	->middleware('permission:cadcat');
	Route::get('ajustes/categorias/q={slug}', ['as' => 'mostracategorianome', 'uses' => 'JahxController@showNomeCategoria']);
	Route::get('ajustes/categorias/{id}', ['as' => 'mostracategoria', 'uses' => 'JahxController@showCategoria']);
	Route::put('ajustes/categorias/{id}', ['as' => 'atualizacategoria', 'uses' => 'JahxController@updateCategoria'])
	->middleware('permission:editcat');

	//rotas vendas usando a logica laravel create-> form d crir, store-> cad no db
	Route::get('vendas/criavenda', ['as' => 'criarvenda', 'uses' => 'VendaController@create']);
	Route::post('vendas', ['as' => 'addvenda', 'uses' => 'VendaController@store'])
	->middleware('permission:cadvenda');
	Route::get('vendas/q={slug}', ['as' => 'mostravendadescricao', 'uses' => 'VendaController@showPorSlug']);
	Route::get('vendas/{id}', ['as' => 'mostravenda', 'uses' => 'VendaController@show']);
	Route::put('vendas/{id}', ['as' => 'atualizavenda', 'uses' => 'VendaController@update'])
	->middleware('permission:editvenda');
	Route::get('vendas/{id}/editar', ['as' => 'editavenda', 'uses' => 'VendaController@edit']);
	Route::patch('vendas/{id}', ['as' => 'cancelavenda', 'uses' => 'VendaController@cancelar'])
	->middleware('permission:cancvenda');
	Route::get('vendas/periodo/venda/{data?}', ['as' => 'buscavendaperiodo', 'uses' => 'VendaController@showPorPeriodo']);

	//rotas itenVendas
	Route::get('itemprodutos/tabela/{descricao}', ['as' => 'tabelaitemproduto', 'uses' => 'ItemVendaController@iteraTabelaItemProdutos']);
	Route::get('itemprodutos/{id}', ['as' => 'insereitempdv', 'uses' => 'ItemVendaController@insereItemPDV']);
	Route::get('itemprodutos/cancelamento/pdv', ['as' => 'cancelaitenspdv', 'uses' => 'ItemVendaController@cancelaItensPDV']);

	//rotas compras
	Route::get('compras/criacompra', ['as' => 'criarcompra', 'uses' => 'CompraController@create']);
	Route::post('compras', ['as' => 'addcompra', 'uses' => 'CompraController@store'])
	->middleware('permission:cadcomp');
	Route::get('compras/q={slug}', ['as' => 'mostracompradescricao', 'uses' => 'CompraController@showPorSlug']);
	Route::get('compras/{id}', ['as' => 'mostracompra', 'uses' => 'CompraController@show']);
	Route::put('compras/{id}', ['as' => 'atualizacompra', 'uses' => 'CompraController@update'])
	->middleware('permission:editcomp');
	Route::get('compras/{id}/editar', ['as' => 'editacompra', 'uses' => 'CompraController@edit']);
	Route::patch('compras/{id}', ['as' => 'cancelacompra', 'uses' => 'CompraController@cancelar'])
	->middleware('permission:canccomp');

	//rotas dav doc aux d venda - pre-venda
	Route::get('davs/criadav', ['as' => 'criardav', 'uses' => 'DAVController@create']);
	Route::post('davs', ['as' => 'adddav', 'uses' => 'DAVController@store']);
	Route::get('davs/q={slug}', ['as' => 'mostradavdescricao', 'uses' => 'DAVController@showPorSlug']);
	Route::get('davs/{id}', ['as' => 'mostradav', 'uses' => 'DAVController@show']);
	Route::put('davs/{id}', ['as' => 'atualizadav', 'uses' => 'DAVController@update']);
	Route::get('davs/{id}/editar', ['as' => 'editadav', 'uses' => 'DAVController@edit']);
	//Route::patch('davs/{id}', ['as' => 'canceladav', 'uses' => 'DAVController@cancelar']);
	Route::delete('davs/{id}', ['as' => 'deletadav', 'uses' => 'DAVController@destroy']);
	Route::patch('davs/{id}', ['as' => 'vendedav', 'uses' => 'DAVController@venderDAV'])
	->middleware('permission:vendedav');
	Route::get('davs/periodo/venda/{data?}', ['as' => 'buscadavperiodo', 'uses' => 'DAVController@showPorPeriodo']);

	//rotas pdf
		//recibo
	Route::get('pdf/{id}', ['as' => 'baixarrecibo', 'uses' => 'VendaController@baixarRecibo']);
	Route::get('pdf/exibir/{id}', ['as' => 'exibirrecibo', 'uses' => 'VendaController@exibirRecibo']);
	Route::get('pdf/dav/{id}', ['as' => 'baixarrecibodav', 'uses' => 'DAVController@baixarRecibo']);
	Route::get('pdf/dav/exibir/{id}', ['as' => 'exibirrecibodav', 'uses' => 'DAVController@exibirRecibo']);
		//cupom
	Route::get('pdf/exibir/cupom/{id}', ['as' => 'exibircupom', 'uses' => 'VendaController@exibirCupom']);
	Route::get('pdf/dav/exibir/cupom/{id}', ['as' => 'exibircupomdav', 'uses' => 'DAVController@exibirCupom']);
	Route::get('pdf/dav/exibir/venda-do-dia/cupom/{data?}', ['as' => 'exibirvendadiacupomdav', 'uses' => 'DAVController@exibirVendaDiaCupom'])
	->middleware('permission:fmtcxdav');
	Route::get('pdf/venda/exibir/venda-do-dia/cupom/{data?}', ['as' => 'exibirvendadiacupomvenda', 'uses' => 'VendaController@exibirVendaDiaCupom'])
	->middleware('permission:fmtcxdav');
	Route::get('pdf/venda/exibir/venda-do-mes/cupom/{data?}', ['as' => 'exibirvendamescupomvenda', 'uses' => 'VendaController@exibirVendaMesCupom'])
	->middleware('permission:fmtcxdav');

	//rotas custos
	Route::post('ajustes/custos', ['as' => 'addcusto', 'uses' => 'JahxController@createCusto'])
	->middleware('permission:cadcusto');
	Route::get('ajustes/custos/q={slug}', ['as' => 'mostracustonome', 'uses' => 'JahxController@showNomeCusto']);
	Route::get('ajustes/custos/{id}', ['as' => 'mostracusto', 'uses' => 'JahxController@showCusto']);
	Route::put('ajustes/custos/{id}', ['as' => 'atualizacusto', 'uses' => 'JahxController@updateCusto'])
	->middleware('permission:editcusto');
	Route::delete('ajustes/custos/{id}', ['as' => 'deletacusto', 'uses' => 'JahxController@destroyCusto'])
	->middleware('permission:remcusto');
	//rotas caixa
	Route::get('registro-do-caixa', ['as' => 'criarregistro', 'uses' => 'CaixaController@index']);
	Route::post('registro-do-caixa', ['as' => 'addregistrocaixa', 'uses' => 'CaixaController@store'])
	->middleware('permission:cadcx');
	Route::get('registro-do-caixa/periodo/{data?}', ['as' => 'buscaregcaixaperiodo', 'uses' => 'CaixaController@showPorPeriodo']);
	Route::get('registro-do-caixa/{id}', ['as' => 'mostraregistro', 'uses' => 'CaixaController@show']);
	Route::put('registro-do-caixa/{id}', ['as' => 'atualizaregistro', 'uses' => 'CaixaController@update'])
	->middleware('permission:editcx');
	Route::delete('registro-do-caixa/{id}', ['as' => 'deletaregistro', 'uses' => 'CaixaController@destroy'])
	->middleware('permission:remcx');

	//rotas contas a pagar
	Route::post('contas-a-pagar', ['as' => 'addapagar', 'uses' => 'ContaController@store'])
	->middleware('permission:cadcontapg');

	//rotas balanco mensal
	Route::get('balanco-mensal/{data?}', ['as' => 'buscabalancoperiodo', 'uses' => 'BalancoController@showPorPeriodo'])
	->middleware('permission:caduser');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/erro-de-permissao', function(){
	return view ('erropermissao');
})->name('erropermissao');
