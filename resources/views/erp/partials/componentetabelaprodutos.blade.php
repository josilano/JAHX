<table class="striped">
  <thead>
    <tr>
      <th>Cód. Barras</th>
      <th>Descrição</th>
      <th>Preço Un.</th>
      <th>Qtd.</th>
      <th>SubTotal</th>
    </tr>
  </thead>
  @isset($tabela_de_produtos)
  <tbody>
      @foreach ($tabela_de_produtos as $itemproduto)
      <tr>
          <td>{{ $itemproduto->ean_produto }}</td>
          <td>{{ $itemproduto->descricao_produto }}</td>
          <td>
            <input type="tel" name="preco-venda" id="preco-venda" onchange="atualizasubtotal('{{ $itemproduto->ean_produto }}');" onKeyUp="maskIt(this,event,'###.###.###,##',true)" value="{{ number_format($itemproduto->preco_vendido, 2, ',', '.') }}">
          </td>

          <td>
            <input type="text" name="{{ $itemproduto->ean_produto }}" id="qtd" onchange="atualizasubtotal('{{ $itemproduto->ean_produto }}');" value="{{ $itemproduto->qtd_venda }}">
            
          </td>

          <td><input type="tel" name="subtotal" id="subtotal" onchange="maskIt(this,event,'###.###.###,##',true)" disabled value="{{ $itemproduto->subtotal }}"></td>
      </tr>
      @endforeach

      @if (session('itensprod'))
      @foreach(session()->get('itensprod') as $item)
        <tr>
          <td>{{ $item->ean_produto }}</td>
          <td>{{ $item->descricao_produto }}</td>
          <td>
            <input type="tel" name="preco-venda" id="preco-venda" onchange="atualizasubtotal('{{ $itemproduto->ean_produto }}');" onKeyUp="maskIt(this,event,'###.###.###,##',true)" value="{{ number_format($item->preco_vendido, 2, ',', '.') }}">
          </td>

          <td>
            <input type="text" name="{{ $item->ean_produto }}qtd" id="qtd" onchange="atualizasubtotal('{{ $itemproduto->ean_produto }}');" value="{{ $item->qtd_venda }}">
            {{ session([$item->qtd_venda => @qtd]) }} {{ @qtd }}
          </td>

          <td><input type="tel" name="subtotal" id="subtotal" onchange="maskIt(this,event,'###.###.###,##',true)" disabled value="{{ $item->subtotal }}"></td>
      </tr>
      @endforeach
      @endif
  </tbody>
  @endisset
</table>