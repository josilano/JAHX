<table class="amber lighten-4" style="font-size: 12px;">
  <thead>
    <tr>
      <th>Item</th>
      <th>Código</th>
      <th>Descrição</th>
      <th>UN</th>
      <th>QTD</th>
      <th>Preço Un</th>
      <th>Total</th>
    </tr>
  </thead>
  @isset($tabela_de_produtos)
  <tbody>
    <?php $i = 1; ?>
    @foreach ($tabela_de_produtos as $itemproduto)
      <tr>
        <td><div style="width: 25px; overflow: auto;">{{ $i }}</div></td>
        <td><div style="width: 100px; overflow: auto;">{{ $itemproduto->ean_produto }}</div></td>
        <td><div style="width: 100px; overflow: auto;">{{ $itemproduto->descricao_produto }}</div></td>
        <td><div style="width: 25px; overflow: auto;" >{{ $itemproduto->un_produto }}</div></td>
        <td><div style="width: 25px; overflow: auto;">{{ $itemproduto->qtd_venda }}</div></td>
        <td><div style="width: 50px; overflow: auto;">R$ {{ number_format($itemproduto->preco_vendido, 2, ',', '.') }}</div></td>
        <td><div style="width: 75px; overflow: auto;">R$ {{ number_format($itemproduto->subtotal, 2, ',', '.') }}</div></td>
      </tr>
      <?php $i++; ?>
      @endforeach
  </tbody>
  @endisset
</table>