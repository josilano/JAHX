<table id="products-table" class="striped">
  <thead>
    <tr>
      <th>Item</th>
      <th>Descrição</th>
      <th>Cód. Barras</th>
      <th>Preço Un.</th>
      <th>Un</th>
      <th>Qtd.</th>
      <th>SubTotal</th>
      <th>Excluir</th>
    </tr>
  </thead>
  
  <tbody>
    <?php $i = 1; ?>
    @foreach($itens as $item)
    <?php $produto = ProdutoFacade::find($item->id_produto); ?>
      <tr>
        <td><span class="item">{{ $i }}</span></td>

        <td>
          <div class="row">
            <div class="col s12">
              <div class="row">
                <div class="input-field col s12">
                  <input type="text" id="{{ $i }}" class="autocomplete" onclick="pegaproduto({{ $i }}, {{ $i }})" name="descricao{{ $i }}" value="{{ $produto->descricao }}">
                </div>
              </div>
            </div>
          </div>
        </td>

        <td><span class="spanean{{ $i }}">{{ $produto->ean }}</span><input type="hidden" name="ean{{ $i }}" value="{{ $produto->ean_ }}"></td>

        <td>
          <input type="tel" name="preco{{ $i }}" onchange="atualizasubtotal('qtd{{ $i }}', 'preco{{ $i }}', 'subtotal{{ $i }}');" onKeyUp="maskIt(this,event,'###.###.###,##',true)" value="{{ number_format($item->preco_compra, 2, ',', '.') }}">
        </td>

        <td><span class="spanun{{ $i }}">{{ $produto->unidade_medida }}</span><input type="hidden" name="id-produto{{ $i }}" value="{{ $produto->id }}"></td>

        <td>
          <div style="width: 35px; overflow: auto;">
            <input type="tel" name="qtd{{ $i }}" onchange="atualizasubtotal('qtd{{ $i }}', 'preco{{ $i }}', 'subtotal{{ $i }}');" value="{{ $item->qtd_compra }}">
          </div>
        </td>

        <td>
          <span class="spansubtotal{{ $i }}">{{ number_format($item->preco_compra * $item->qtd_compra, 2, ',', '.') }}</span>
          <input type="hidden" name="subtotal{{ $i }}" value="{{ number_format($item->preco_compra * $item->qtd_compra, 2, ',', '.') }}">
        </td>

        <td>
          <button onclick="RemoveTableRow(this, 'spansubtotal{{ $i }}')" type="button" class="btn-floating waves-effect red"><i class="tiny material-icons">clear</i></button>
        </td>

      </tr>
      <?php $i++; ?>
    @endforeach
  </tbody>

  <tfoot>
    <tr>
      <td colspan="5" style="text-align: left;">
        <button onclick="AddTableRow()" type="button" class="btn-floating waves-effect yellow accent-4"><i class="tiny material-icons black-text">add</i></button>
      </td>
    </tr>
  </tfoot>
</table>