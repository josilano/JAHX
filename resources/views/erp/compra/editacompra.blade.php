@extends('erp.template.templateerp')

@section('title', 'JahX Compras')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">EDITA COMPRA</h3>
    </div>
@endsection

@section('content')
    @if(session('msg'))
        <div id="modal1" class="modal">
            <div class="modal-content">
              <h4>Erro no servidor</h4>
              <p>{{ session('msg') }}</p>
            </div>
            <div class="modal-footer">
              <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
        </div>
    @endif
    <div class="col l3 m3 s4">
        <a href="{{ route('jahx.compras') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons waves-effect blue-text">add_shopping_cart</i>
            COMPRAS
        </a>
    </div>
    <br><br>
    @if (isset($compra))
        <div class="table-container">
        <form action="{{ route('jahx.atualizacompra', ['id' => $compra->id]) }}" method="post" id="form-update-compra">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            
            <input type="hidden" name="id-usuario" value="{{ Auth::user()->id }}">
            <h4 class="col l6 m6 s12 black yellow-text text-accent-4">Compra nº {{ $compra->id }}</h4>
            <h4 class="col l6 m6 s12 yellow accent-4">Status: {{ $compra->status }}</h4>
            @include ('erp.partials.compras.componenteitensprodutosupdatecompra')
            <div class="row">
                <div class="input-field col l6 m6 s12">
                    <input id="numero-nota" type="tel" class="validate" name="numero-nota" value="{{ $compra->numero_nota }}">
                    <label for="numero-nota">Número da Nota</label>
                </div>
                <div class="input-field col l3 m6 s12">
                    <input type="text" class="datepicker" name="data-emissao" id="data-emissao" value="{{ strftime('%d/%m/%Y', strtotime($compra->data_emissao)) }}">
                    <label for="data-emissao">Data de Emissão</label>
                </div>
                <div class="input-field col l3 m6 s12">
                    <input type="text" class="datepicker" name="vencimento" id="vencimento" value="{{ strftime('%d/%m/%Y', strtotime($compra->vencimento)) }}">
                    <label for="vencimento">Vencimento</label>
                </div>
            </div>

            <div class="row">
                <div class="col l4 m5 s12">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Forma de Pagamento</legend>
                        <i class="material-icons black-text prefix">card_membership</i>
                        <?php $formapgs = FormaPagamentoFacade::all(); ?>
                        <select id="forma-pg-compra" name="forma-pg-compra">
                            <option value="{{ $compra->forma_pg_compra }}" selected>{{ $compra->forma_pg_compra }}</option>
                            @foreach($formapgs as $fpg)
                            <option value="{{ $fpg->forma }}">{{ $fpg->forma }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
                <div class="col l2 m2 s2">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Parcelas</legend>
                            <i class="material-icons purple-text text-lighten-4 prefix">close</i>
                            <select id="parcelas" name="parcelas">
                                <option value="{{ $compra->parcelas }}" selected>{{ $compra->parcelas }}</option>
                                @for($i = 1; $i < 11; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                    </fieldset>
                </div>
                <div class="col l3 m5 s10">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Total</legend>
                        <i class="material-icons yellow-text text-accent-4 prefix">monetization_on</i>
                        <input type="tel" name="total" onKeyUp="maskIt(this,event,'###.###.###,##',true)" value="{{ number_format($compra->total_compra, 2, ',', '.') }}">
                    </fieldset>
                </div>
                <div class="col l3 m6 s12">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Restante</legend>
                        <i class="material-icons yellow-text text-accent-4 prefix">monetization_on</i>
                        <input type="tel" name="restante" onKeyUp="maskIt(this,event,'###.###.###,##',true)" required value="{{ number_format($compra->restante, 2, ',', '.') }}">
                    </fieldset>
                </div>
            </div>
            
            <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit">Atualizar Compra
                <i class="material-icons right black-text">send</i>
            </button>
        </form>
    </div>
    @endif
@endsection

@section('rodape')
    
@endsection

@section('script')
    <script src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
    <script type="text/javascript">
            $(document).ready(function(){
                $("#data-emissao").mask("99/99/9999");
            });

            var linhai = '{{ count($itens) }}';
            function atualizasubtotal(iqtd, ipreco, isubtotal) {
                var qtd = parseFloat($('input[type=tel][name='+iqtd+']').val().replace(',', '.'));
                var preco = parseFloat($('input[type=tel][name='+ipreco+']').val().replace('.', '').replace(',', '.'));
                var subtotal = qtd * preco;
                var decrementasubtotal = parseFloat($('input[type=hidden][name='+isubtotal+']').val().replace('.', '').replace(',', '.'));
                $('.span'+isubtotal).html(subtotal.toFixed(2).replace('.', ','));
                $('input[type=hidden][name='+isubtotal+']').val(subtotal.toFixed(2).replace('.', ','));
            }
            
            function pegaproduto(nomeinput, linhatabela){
                $('#'+nomeinput).autocomplete({
                data: {
                  @foreach($produtos as $produto)
                  "{{ $produto->descricao }}": null,
                  @endforeach
                },
                limit: 20,
                onAutocomplete: function(descricao) {
                $.ajax({
                    url: "/erp/produtos/descricao/"+descricao,
                    type: 'GET',
                    //data: $('#form-itemtable').serialize(),//{slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        $('input[type=hidden][name=ean]').attr('name', 'ean'+linhatabela);//.val(response.ean);
                        $('.spanean').attr('class', 'spanean'+linhatabela);
                        $('input[type=tel][name=preco-venda]').attr('name', 'preco'+linhatabela);//.val(response.preco_venda.toFixed(2).replace('.', ','));
                        $('.spanun').attr('class', 'spanun'+linhatabela);//.html(response.unidade_medida);
                        $('input[type=tel][name=qtd]').attr('name', 'qtd'+linhatabela);//.val(1);
                        $('.spansubtotal').attr('class', 'spansubtotal'+linhatabela);
                        $('input[type=hidden][name=un]').attr('name', 'id-produto'+linhatabela);

                        $('input[type=hidden][name=ean'+linhatabela+']').val(response.ean);
                        $('.spanean'+linhatabela).html(response.ean);
                        $('input[type=tel][name=preco'+linhatabela+']').val(response.preco_venda.toFixed(2).replace('.', ','));
                        $('.spanun'+linhatabela).html(response.unidade_medida);
                        $('input[type=tel][name=qtd'+linhatabela+']').val(1);
                        $('input[type=hidden][name=subtotal]').attr('name', 'subtotal'+linhatabela);
                        $('input[type=hidden][name=id-produto'+linhatabela+']').val(response.id);
                        
                        atualizasubtotal('qtd'+linhatabela, 'preco'+linhatabela, 'subtotal'+linhatabela);
                    }
                });
                },
                minLength: 1,
                });
            }

            (function($) {
                AddTableRow = function() {

                var newRow = $("<tr>");
                var cols = "";
                var i = parseInt(linhai);
                linhai++;
                var linhatabela = i + 1;
                $('.item').attr('class', 'item'+i);

                cols += '<td><span class="item">'+ linhatabela +'</span></td>';
                cols += '<td><div class="row">'+
                '<div class="col s12">'+
                    '<div class="row">'+
                      '<div class="input-field col s12">'+
                        '<input type="text" id="'+linhatabela+'" class="autocomplete" onclick="pegaproduto('+linhatabela+', '+linhatabela+')" name="descricao'+linhatabela+'">'+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</div></td>';
                cols += '<td><span class="spanean"></span><input type="hidden" name="ean"></td>';
                cols += '<td><input type="tel" name="preco-venda" onchange="atualizasubtotal(\'qtd'+linhatabela+'\', \'preco'+linhatabela+'\', \'subtotal'+linhatabela+'\');" onKeyUp="maskIt(this,event,\'###.###.###,##\',true)"></td>';
                cols += '<td><span class="spanun"></span><input type="hidden" name="un"></td>';
                cols += '<td><div style="width: 35px; overflow: auto;"><input type="tel" name="qtd" onchange="atualizasubtotal(\'qtd'+linhatabela+'\', \'preco'+linhatabela+'\', \'subtotal'+linhatabela+'\');"></div></td>';
                cols += '<td><span class="spansubtotal"></span><input type="hidden" name="subtotal" value="0"></td>';

                cols += '<td>';
                cols += '<button onclick="RemoveTableRow(this, \'spansubtotal'+linhatabela+'\')" type="button" class="btn-floating waves-effect red"><i class="tiny material-icons">clear</i></button>';
                cols += '</td>';

                newRow.append(cols);
                $("#products-table").append(newRow);


                return false;
                };
            })(jQuery);

            (function($) {
                RemoveTableRow = function(item, nomesubtotal) {
                var subtotalvendas = parseFloat($('.'+nomesubtotal).html().replace('.', '').replace(',', '.'));
                var tr = $(item).closest('tr');

                tr.fadeOut(400, function() {
                    tr.remove();  
                });

                return false;
                }
            })(jQuery);
        </script>
@endsection