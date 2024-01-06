<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    protected $fillable = [
    	'id_venda',
    	'id_produto',
    	'qtd_venda',
    	'preco_vendido',
    	'ean_produto',
    	'descricao_produto',
    	'subtotal'
    ];
//21/03 fill deveria ter  id_venda, ean, descricao, preco_venda, qtd, subtotal
    protected static $collection = array(); //= collect([1, 2, 3]);//$tabela_de_produtos = collect([1]);//new ArrayObject();

    public function __construct()
    {
    	//$this->collection = collect();
    }

    public static function novoItemVenda()
    {
        return new ItemVenda();
    }

    public static function addItemTabela($produto)
    {
    	array_push(self::$collection, $produto);// = collect();
    	//dd(self::$collection);//return self::$collection;
    }

    public static function getItensTabela()
    {
    	return self::$collection;
    }

    public function vendas()
    {
        return $this->belongsTo('App\Venda', 'id_venda');
    }

    public static function iteraItens($qtd_itens, $req)
    {
        $itens = [];
        $i = 1;
        //dd($req['descricao3']);
        while (count($itens) < $qtd_itens) {
            if ($i - count($itens) == 5) return null;
            elseif (!isset($req['descricao'.$i])) $i++;//($req['descricao' . $i] == null) $i++;
            else{
                $itemVenda = ItemVenda::novoItemVenda();
                $itemVenda->descricao_produto = $req['descricao' . $i];
                $itemVenda->ean_produto = $req['ean' . $i];
                $itemVenda->un_produto = $req['un' . $i];
                $itemVenda->qtd_venda = number_format((double)str_replace(',', '.', $req['qtd' . $i]), 3, '.', '');
                $itemVenda->preco_vendido = number_format((double)str_replace(',', '.', str_replace('.', '', $req['preco' . $i])), 2, '.', '');
                $itemVenda->subtotal = number_format((double)str_replace(',', '.', str_replace('.', '', $req['subtotal' . $i])), 2, '.', '');
                array_push($itens,  $itemVenda);
                $i++;
            }
        }
        return $itens;
    }

    public static function excluir($id)
    {
        return $itens = ItemVenda::where('id_venda', $id)->delete();
    }
}
