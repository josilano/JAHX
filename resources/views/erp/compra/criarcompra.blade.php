@extends('erp.template.templateerp')

@section('title', 'JahX Iniciar Compra')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">INICIAR COMPRA</h3>
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

    <h5 class="center-align yellow-text text-accent-4 black">Selecione o fornecedor</h5>
    @include ('erp.partials.componenteautocomplete')

    @include ('erp.partials.clientes.componentemostraumcliente', ['cliente' => $fornecedor])

    <h5 class="center-align yellow-text text-accent-4 black">Selecione os produtos</h5>

    <div class="table-container">
        <form action="{{ route('jahx.addcompra') }}" method="post" id="form-create-compra">
            {{ csrf_field() }}
            <input type="hidden" name="id-fornecedor" value="1">
            <input type="hidden" name="id-usuario" value="{{ Auth::user()->id }}">
            @include ('erp.partials.componenteitensprodutos')
            <div class="row">
                <div class="input-field col l6 m6 s12">
                    <input id="numero-nota" type="tel" class="validate" name="numero-nota">
                    <label for="numero-nota">Número da Nota</label>
                </div>
                <div class="input-field col l3 m6 s12">
                    <input type="text" class="datepicker" name="data-emissao" id="data-emissao" required>
                    <label for="data-emissao">Data de Emissão</label>
                </div>
                <div class="input-field col l3 m6 s12">
                    <input type="text" class="datepicker" name="vencimento" id="vencimento" required>
                    <label for="vencimento">Vencimento</label>
                </div>
            </div>
            <div class="row">
                <div class="col l4 m5 s12">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Forma de Pagamento</legend>
                        <i class="material-icons black-text prefix">card_membership</i>
                        <?php $formapgs = FormaPagamentoFacade::all(); ?>
                        <select id="forma-pg-venda" name="forma-pg-compra">
                            <option value="" disabled selected>Selecione a forma de pagamento</option>
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
                                <option value="1" selected>1</option>
                                @for($i = 2; $i < 11; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                    </fieldset>
                </div>
                <div class="col l3 m5 s10">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Total</legend>
                        <i class="material-icons yellow-text text-accent-4 prefix">monetization_on</i>
                        <input type="tel" name="total" onKeyUp="maskIt(this,event,'###.###.###,##',true)" required>
                    </fieldset>
                </div>
                <div class="col l3 m6 s12">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Restante</legend>
                        <i class="material-icons yellow-text text-accent-4 prefix">monetization_on</i>
                        <input type="tel" name="restante" onKeyUp="maskIt(this,event,'###.###.###,##',true)" required value="0,00">
                    </fieldset>
                </div>
            </div>
            
            <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit">Finalizar Compra
                <i class="material-icons right black-text">send</i>
            </button>
        </form>
    </div>
    
@endsection

@section('rodape')
    @if(isset($comprasexception))
        @include('erp.partials.msgexception', ['exception' => $comprasexception])
    @endif

    @if(isset($cadcompraexception))
        @include('erp.partials.msgexception', ['exception' => $cadcompraexception])
    @endif
@endsection

@section('script')
    <script src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#data-emissao").mask("99/99/9999");
            $('#autocomplete-input').autocomplete({
            data: {
              @foreach($fornecedores as $fornecedor)
              "{{ $fornecedor->nome_rsocial }}": null,
              @endforeach
            },
            limit: 20,
            onAutocomplete: function(slug) {
                $.ajax({
                    url: "/erp/fornecedores/nome/"+slug,
                    type: 'GET',
                    //data: {slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        $('#pessoa_tipo').html(response.pessoa_tipo);
                        $('#nome_rsocial').html(response.nome_rsocial);
                        $('#cpf_cnpj').html(response.cpf_cnpj);
                        $('#nome_fantasia').html(response.nome_fantasia);
                        $('#email').html(response.email);
                        $('#logradouro').html(response.logradouro);
                        $('#numero').html(response.numero);
                        $('#complemento').html(response.complemento);
                        $('#bairro').html(response.bairro);
                        $('#cidade').html(response.cidade);
                        $('#estado').html(response.estado);
                        $('#cep').html(response.cep);
                        $('#tel_principal').html(response.tel_principal);
                        $('#tel_secundario').html(response.tel_secundario);
                        $('.linkeditarcliente').attr('href', '/erp/fornecedores/'+response.id);
                        $('input[type=hidden][name=id-fornecedor]').val(response.id);
                        $('#autocomplete-input').val('');
                    }
                });
            },
            minLength: 1,
          });
        });
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
                        $('input[type=hidden][name=ean]').attr('name', 'ean'+linhatabela);
                        $('.spanean').attr('class', 'spanean'+linhatabela);
                        $('input[type=tel][name=preco-venda]').attr('name', 'preco'+linhatabela);
                        $('.spanun').attr('class', 'spanun'+linhatabela);
                        $('input[type=tel][name=qtd]').attr('name', 'qtd'+linhatabela);
                        $('.spansubtotal').attr('class', 'spansubtotal'+linhatabela);
                        $('input[type=hidden][name=un'+linhatabela+']').attr('name', 'id-produto'+linhatabela);

                        $('input[type=hidden][name=ean'+linhatabela+']').val(response.ean);
                        $('.spanean'+linhatabela).html(response.ean);
                        $('input[type=tel][name=preco'+linhatabela+']').val(response.preco_venda.toFixed(2).replace('.', ','));
                        $('.spanun'+linhatabela).html(response.unidade_medida);
                        $('input[type=tel][name=qtd'+linhatabela+']').val(1);
                        $('input[type=hidden][name=subtotal]').attr('name', 'subtotal'+linhatabela);
                        $('input[type=hidden][name=id-produto'+linhatabela+']').val(response.id);
                        $('#btn-add-table-row').attr('disabled', false);
                        atualizasubtotal('qtd'+linhatabela, 'preco'+linhatabela, 'subtotal'+linhatabela);
                    }
                });
            },
            minLength: 1,
          });
        }
    var linhai = 1;
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
                    '<input type="text" id="'+linhatabela+'" class="autocomplete" onclick="pegaproduto('+linhatabela+', '+linhatabela+')" name="descricao'+linhatabela+'" required>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div></td>';
            cols += '<td><span class="spanean'+linhatabela+'"></span><input type="hidden" name="ean'+linhatabela+'"></td>';
            cols += '<td><input type="tel" name="preco'+linhatabela+'" onchange="atualizasubtotal(\'qtd'+linhatabela+'\', \'preco'+linhatabela+'\', \'subtotal'+linhatabela+'\');" onKeyUp="maskIt(this,event,\'###.###.###,##\',true)" required></td>';
            cols += '<td><span class="spanun'+linhatabela+'"></span><input type="hidden" name="un'+linhatabela+'"></td>';
            cols += '<td><div style="width: 35px; overflow: auto;"><input type="tel" name="qtd'+linhatabela+'" onchange="atualizasubtotal(\'qtd'+linhatabela+'\', \'preco'+linhatabela+'\', \'subtotal'+linhatabela+'\');" required></div></td>';
            cols += '<td><span class="spansubtotal'+linhatabela+'"></span><input type="hidden" name="subtotal'+linhatabela+'" id="subtotal'+linhatabela+'" value="0"></td>';

            cols += '<td>';
            cols += '<button onclick="RemoveTableRow(this, \'subtotal'+linhatabela+'\')" type="button" class="btn-floating waves-effect red"><i class="tiny material-icons">clear</i></button>';
            cols += '</td>';

            newRow.append(cols);
            $("#products-table").append(newRow);
            $('#btn-add-table-row').attr('disabled', true);

            return false;
            };
        })(jQuery);

        (function($) {
            RemoveTableRow = function(item, nomesubtotal) {
            var subtotalvendas = parseFloat($('#'+nomesubtotal).val().replace('.', '').replace(',', '.'));
            var tr = $(item).closest('tr');

            tr.fadeOut(400, function() {
                tr.remove();  
            });
            $('#btn-add-table-row').attr('disabled', false);
            return false;
            }
        })(jQuery);
    </script>

    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
@endsection