<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $unidademedida = [
            ['AMPOLA', 'AMPOLA'],
			['BALDE', 'BALDE'],
			['BANDEJ', 'BANDEJA'],
			['BARRA', 'BARRA'],
			['BISNAG', 'BISNAGA'],
			['BLOCO', 'BLOCO'],
			['BOBINA', 'BOBINA'],
			['BOMB', 'BOMBONA'],
			['CAPS', 'CAPSULA'],
			['CART', 'CARTELA'],
			['CENTO', 'CENTO'],
			['CJ', 'CONJUNTO'],
			['CM', 'CENTIMETRO'],
			['CM2', 'CENTIMETRO QUADRADO'],
			['CX', 'CAIXA'],
			['CX2', 'CAIXA COM 2 UNIDADES'],
			['CX3', 'CAIXA COM 3 UNIDADES'],
			['CX5', 'CAIXA COM 5 UNIDADES'],
			['CX10', 'CAIXA COM 10 UNIDADES'],
			['CX15', 'CAIXA COM 15 UNIDADES'],
			['CX20', 'CAIXA COM 20 UNIDADES'],
			['CX25', 'CAIXA COM 25 UNIDADES'],
			['CX50', 'CAIXA COM 50 UNIDADES'],
			['CX100', 'CAIXA COM 100 UNIDADES'],
			['DISP', 'DISPLAY'],
			['DUZIA', 'DUZIA'],
			['EMBAL', 'EMBALAGEM'],
			['FARDO', 'FARDO'],
			['FOLHA', 'FOLHA'],
			['FRASCO', 'FRASCO'],
			['GALAO', 'GALÃO'],
			['GF', 'GARRAFA'],
			['GRAMAS', 'GRAMAS'],
			['JOGO', 'JOGO'],
			['KG', 'QUILOGRAMA'],
			['KIT', 'KIT'],
			['LATA', 'LATA'],
			['LITRO', 'LITRO'],
			['M', 'METRO'],
			['M2', 'METRO QUADRADO'],
			['M3', 'METRO CÚBICO'],
			['MILHEI', 'MILHEIRO'],
			['ML', 'MILILITRO'],
			['MWH', 'MEGAWATT HORA'],
			['PACOTE', 'PACOTE'],
			['PALETE', 'PALETE'],
			['PARES', 'PARES'],
			['PC', 'PEÇA'],
			['POTE', 'POTE'],
			['K', 'QUILATE'],
			['RESMA', 'RESMA'],
			['ROLO', 'ROLO'],
			['SACO', 'SACO'],
			['SACOLA', 'SACOLA'],
			['TAMBOR', 'TAMBOR'],
			['TANQUE', 'TANQUE'],
			['TON', 'TONELADA'],
			['TUBO', 'TUBO'],
			['UNID', 'UNIDADE'],
			['VASIL', 'VASILHAME'],
			['VIDRO', 'VIDRO']
			
        ];
        foreach ($unidademedida as $un) {
            DB::table('unidade_medidas')->insert([
            	'sigla' => $un[0],
                'descricao' => $un[1],
            ]);
        }

        $formapg = [
        	'DINHEIRO',
        	'CARTÃO DE CRÉDITO',
        	'CARTÃO DE DÉBITO',
        	'BOLETO',
        	'CHEQUE'
        ];
        foreach ($formapg as $forma) {
            DB::table('forma_pagamentos')->insert([
            	'forma' => $forma
            ]);
        }

        $marca = ['SEM MARCA'];
        foreach ($marca as $ma) {
            DB::table('marcas')->insert([
            	'nome_marca' => $ma
            ]);
        }

        $categoria = ['SEM CATEGORIA'];
        foreach ($categoria as $cat) {
            DB::table('categorias')->insert([
            	'nome_categoria' => $cat
            ]);
        }

        $cliente = [
        	['pf', 'CONSUMIDOR FINAL']
        ];
        foreach ($cliente as $cli) {
            DB::table('clientes')->insert([
            	'pessoa_tipo' => $cli[0],
            	'nome_rsocial' => $cli[1],
            ]);
        }

        $fornecedor = [
        	['pj', 'SEM FORNECEDOR']
        ];
        foreach ($fornecedor as $forn) {
            DB::table('fornecedores')->insert([
            	'pessoa_tipo' => $forn[0],
            	'nome_rsocial' => $forn[1],
            ]);
		}

        $user = new \App\User();
        $user->name = 'Admin';
        $user->email = 'demo@demo.com';
        $user->password = bcrypt('erpdemo');
        $user->cargo = 'admin';
		$user->save();
		
		$permissao = [
			['CADASTRAR CLIENTE', 'CADCLI'],
			['EDITAR CLIENTE', 'EDITCLI'],
			['CADASTRAR FORNECEDOR', 'CADFORNCD'],
			['EDITAR FORNECEDOR', 'EDITFORNCD'],
			['CADASTRAR CATEGORIA', 'CADCAT'],
			['EDITAR CATEGORIA', 'EDITCAT'],
			['CADASTRAR MARCA', 'CADMARCA'],
			['EDITAR MARCA', 'EDITMARCA'],
			['CADASTRAR UNIDADE DE MEDIDA', 'CADUN'],
			['EDITAR UNIDADE DE MEDIDA', 'EDITUN'],
			['CADASTRAR FORMA DE PAGAMENTO', 'CADFORMPG'],
			['EDITAR FORMA DE PAGAMENTO', 'EDITFORMPG'],
			['CADASTRAR PRODUTO', 'CADPROD'],
			['EDITAR PRODUTO', 'EDITPROD'],
			['CADASTRAR COMPRA', 'CADCOMP'],
			['EDITAR COMPRA', 'EDITCOMP'],
			['CANCELAR COMPRA', 'CANCCOMP'],
			['CADASTRAR VENDA', 'CADVENDA'],
			['EDITAR VENDA', 'EDITVENDA'],
			['CANCELAR VENDA', 'CANCVENDA'],
			['CADASTRAR DAV', 'CADDAV'],
			['EDITAR DAV', 'EDITDAV'],
			['CANCELAR DAV', 'CANCDAV'],
			['VENDER DAV', 'VENDEDAV'],
			['CADASTRAR USUARIO', 'CADUSER'],
			['EDITAR USUARIO', 'EDITUSER'],
			['LISTAR USUARIO', 'LISTUSER'],
			['CADASTRAR PERMISSAO', 'CADPERM'],
			['EDITAR PERMISSAO', 'EDITPERM'],
			['EDITAR PERMISSAO DO USUARIO', 'EDITPERMUSER']
        ];
        foreach ($permissao as $p) {
            DB::table('permissions')->insert([
				//'user_id' => 1,
				'funcao' => $p[0],
				'cod_funcao' => $p[1]
            ]);
		}

		for ($i = 1; $i <= count($permissao); $i++) {
            DB::table('permission_user')->insert([
				'user_id' => 1,
				'permission_id' => $i
            ]);
        }
    }
}
