<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPreVenda extends Model
{
    protected $table = 'item_prevendas';

    protected $fillable = [
    	'id_prevenda',
    	'id_produto',
    	'qtd_venda',
    	'preco_vendido',
    	'ean_produto',
    	'descricao_produto',
    	'subtotal'
    ];

    public static function novoItemPreVenda()
    {
        return new ItemPreVenda();
    }

    public function preVendas()
    {
        return $this->belongsTo('App\PreVenda', 'id_prevenda');
    }

    public static function iteraItens($qtd_itens, $req)
    {
        $itens = [];
        $i = 1;
        
        while (count($itens) < $qtd_itens) {
            if ($i - count($itens) == 5) return null;
            elseif (!isset($req['descricao'.$i])) $i++;
            else{
                $itemVenda = ItemPreVenda::novoItemPreVenda();
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
        return $itens = ItemPreVenda::where('id_prevenda', $id)->delete();
    }
}
