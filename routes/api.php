<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/clientes', ['as'=> 'apiclientes', 'uses' => 'APIClienteController@apiClientes']);
Route::post('login', 'AuthenticateController@authenticate');
Route::get('/produtos', 'APIProdutoController@apiProdutos');
Route::get('/forma-de-pagamentos', 'APIFormaPagamentoController@apiFormaPagamentos');
Route::post('/vendas', 'APIVendaController@apiVendas');
Route::get('/me', 'AuthenticateController@getAuthenticatedUser');