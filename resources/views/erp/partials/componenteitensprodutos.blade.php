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
    <tr>
      <td><span class="item">1</span></td>
      <td>
        <div class="row">
          <div class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <input type="text" id="1" class="autocomplete" onclick="pegaproduto(1, 1)" name="descricao1">
              </div>
            </div>
          </div>
        </div>
      </td>

      <td><span class="spanean1"></span><input type="hidden" name="ean1"></td>
      
      <td>
        <input type="tel" name="preco1" onchange="atualizasubtotal('qtd1', 'preco1', 'subtotal1');" onKeyUp="maskIt(this,event,'###.###.###,##',true)">
      </td>

      <td><span class="spanun1"></span><input type="hidden" name="un1"></td>

      <td>
        <div style="width: 45px; overflow: auto;">
          <input type="tel" name="qtd1" onchange="atualizasubtotal('qtd1', 'preco1', 'subtotal1');">
        </div>
      </td>

      <td>
        <span class="spansubtotal1"></span>
        <input type="hidden" name="subtotal1" id="subtotal1" value="0">
      </td>

      <td><button onclick="RemoveTableRow(this, 'subtotal1')" type="button" class="btn-floating waves-effect red"><i class="tiny material-icons">clear</i></button></td>
    </tr>
  </tbody>

  <tfoot>
    <tr>
      <td colspan="5" style="text-align: left;">
        <button onclick="AddTableRow()" id="btn-add-table-row" disabled type="button" class="btn-floating waves-effect amber accent-4"><i class="tiny material-icons black-text">add</i></button>
      </td>
    </tr>
  </tfoot>
</table>