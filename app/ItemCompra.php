<?php

namespace App;

use App\Facades\ProdutoFacade;
use Illuminate\Database\Eloquent\Model;

class ItemCompra extends Model
{
    protected $fillable = [
    	'id_compra',
    	'id_produto',
    	'qtd_compra',
    	'preco_compra'
    ];
    
    public static function novoItemCompra()
    {
        return new ItemCompra();
    }

    public function compras()
    {
        return $this->belongsTo('App\Compra', 'id_compra');
    }

    public static function iteraItens($qtd_itens, $req)
    {
        $itens = [];
        $i = 1;
        
        while (count($itens) < $qtd_itens) {
            if ($i - count($itens) == 5) return null;
            elseif (!isset($req['descricao'.$i])) $i++;
            else{
                $itemCompra = ItemCompra::novoItemCompra();
                $itemCompra->id_produto = $req['id-produto' . $i];
                $itemCompra->qtd_compra = number_format((double)str_replace(',', '.', $req['qtd' . $i]), 3, '.', '');
                $itemCompra->preco_compra = number_format((double)str_replace(',', '.', str_replace('.', '', $req['preco' . $i])), 2, '.', '');
                array_push($itens,  $itemCompra);
                $i++;
            }
        }
        return $itens;
    }

    public static function excluir($id)
    {
        //return ItemCompra::where('id_compra', $id)->delete();
        $itens = ItemCompra::where('id_compra', $id)->get();
        if (count($itens) == 0) return 0;
        foreach ($itens as $item) {
            if (ProdutoFacade::where('id', $item->id_produto)->decrement('qtd', $item->qtd_compra))
                $exclui = ItemCompra::where('id', $item->id)->delete();
        }
        return $exclui;
    }
}
