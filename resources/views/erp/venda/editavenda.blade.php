@extends('erp.template.templateerp')

@section('title', 'JahX Vendas')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">EDITA VENDA</h3>
    </div>
@endsection

@section('content')
    @if (session('msg'))
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
        <a href="{{ route('jahx.vendas') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons waves-effect blue-text">shopping_cart</i>
            VENDAS
        </a>
    </div>
    <br><br>
    @if (isset($venda))
        <h4 class="col l6 m6 s12 black yellow-text text-accent-4">Venda nº {{ $venda->id }}</h4>
        <h4 class="col l6 m6 s12 yellow accent-4">Status: {{ $venda->status }}</h4>
        <div class="fixed-action-btn">
            <a class="btn-flat btn-large amber accent-4 right" id="btn-qtd-linhai" href="#btn-spy">
            </a><br><br><br>
            <a class="btn-floating btn-large amber accent-4" id="btn-para-sumir">
                <i class="fa fa-barcode fa-2x black-text prefix" aria-hidden="true"></i>
            </a>
            <div class="input-field col s12 m6 l9">
                <input type="text" id="leitor-ean" maxlength="14" data-length="14" class="scale-transition scale-in">
            </div>
        </div>
        <div class="table-container">
        <form action="{{ route('jahx.atualizavenda', ['id' => $venda->id]) }}" method="post" id="form-update-venda">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            
            <input type="hidden" name="id-usuario" value="{{ Auth::user()->id }}">
            @include ('erp.partials.componenteitensprodutosupdate')
            <div class="row scrollspy" id="btn-spy">
                <div class="col l2 m4 s12 offset-l4 offset-m4">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Total Produtos</legend>
                        <i class="material-icons yellow-text text-accent-4 prefix">monetization_on</i>
                        <input type="hidden" name="totalitens" id="totalitens" value="{{ number_format($venda->total_itens, 2, ',', '.') }}">
                        <span class="totalitens">{{ number_format($venda->total_itens, 2, ',', '.') }}</span>
                    </fieldset>
                </div>
                <div class="col l4 m4 s12">
                    <div class="row">
                        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Desconto</legend>
                            <div class="input-field col s12 m3 l3">
                                <select name="tipo-desconto" id="tipo-desconto" onchange="calculaDesconto()">
                                    @if ($venda->tipo_desconto === 'real')
                                        <option value="real" selected>R$</option>
                                    @else
                                        <option value="porcento" selected>%</option>
                                    @endif
                                    <option value="real" >R$</option>
                                    <option value="porcento">%</option>
                                </select>        
                            </div>

                            <div class="input-field col s12 m7 l7">
                                <i class="material-icons yellow-text text-accent-4 prefix">money_off</i>
                                <input type="tel" id="desconto" name="desconto" maxlength="6" data-length="6" onchange="calculaDesconto()" value="{{ $venda->desconto }}">
                            </div>

                            <div class="col l2 m2 s12 valign-wrapper">
                                <input type="hidden" name="valor-desconto" id="valor-desconto" value="0">
                                <span class="valor-desconto"></span>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="col l2 m4 s12">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Total</legend>
                        <i class="material-icons yellow-text text-accent-4 prefix">monetization_on</i>
                        <input type="hidden" name="total" id="total" value="{{ number_format($venda->total_venda, 2, ',', '.') }}">
                        <span class="total">{{ number_format($venda->total_venda, 2, ',', '.') }}</span>
                    </fieldset>
                </div>
                <div class="col l6 m6 s6">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Forma de Pagamento</legend>
                        <i class="material-icons yellow-text text-accent-4 prefix">monetization_on</i>
                        <?php $formapgs = FormaPagamentoFacade::all(); ?>
                        <select id="forma-pg-venda" name="forma-pg-venda">
                            <option value="{{ $venda->forma_pg_venda }}" selected>{{ $venda->forma_pg_venda }}</option>
                            @foreach($formapgs as $fpg)
                            <option value="{{ $fpg->forma }}">{{ $fpg->forma }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
                <div class="col l6 m6 s6">
                    <div class="row">
                        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                            <legend>Parcelas</legend>
                            <div class="input-field col s3 m6 l6">
                                <i class="material-icons yellow-text text-accent-4 prefix">monetization_on</i>
                                <select id="parcelas" name="parcelas" onchange="calculaParcelamento()">
                                    <option value="{{ $venda->parcelas }}" selected>{{ $venda->parcelas }}</option>
                                    @for($i = 1; $i < 11; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="input-field col s9 m6 l6">
                                <span class="parcelavenda">valor da parcela</span>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="divider"></div>
            @include ('erp.partials.componentedinheirotrocoupdate', ['vtemp' => $venda])
            <div class="divider"></div>
            
            <button class="btn waves-effect waves-light yellow accent-4 black-text" id="btn-send-venda" type="submit">Atualizar Venda
                <i class="material-icons right black-text">send</i>
            </button>
        </form>
    </div>
    @endif
@endsection

@section('rodape')
    
@endsection

@section('script')

    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
    <script type="text/javascript">
        $(document).ready(function(){
            $('#btn-para-sumir').on('click', function(){
                if ($('#leitor-ean').hasClass('scale-in')){
                    $('#leitor-ean').removeClass('scale-in');
                    $('#leitor-ean').addClass('scale-out');
                }
                else {
                    $('#leitor-ean').addClass('scale-in');
                }
            });
            $('#btn-qtd-linhai').html(qtditens);
        });

        var linhai = parseInt('{{ count($itens) }}')+1;
        var pode_add_table_row = true;
        function atualizasubtotal(iqtd, ipreco, isubtotal) {
            var qtd = parseFloat($('input[type=tel][name='+iqtd+']').val().replace(',', '.'));
            var preco = parseFloat($('input[type=tel][name='+ipreco+']').val().replace('.', '').replace(',', '.'));
            var ean = parseInt($('input[type=hidden][name=ean'+iqtd.replace('qtd', '')+']').val());
            if (!Number.isNaN(qtd) & !Number.isNaN(preco) & !Number.isNaN(ean)){
                var subtotal = qtd * preco;
                var decrementasubtotal = parseFloat($('input[type=hidden][name='+isubtotal+']').val().replace('.', '').replace(',', '.'));
                $('.span'+isubtotal).html(subtotal.toFixed(2).replace('.', ','));
                $('input[type=hidden][name='+isubtotal+']').val(subtotal.toFixed(2).replace('.', ','));
                calculaTotalProdutos(subtotal, decrementasubtotal);
            }
        }

        var tvendas = parseFloat($('input[type=hidden][name=totalitens]').val().replace('.', '').replace(',', '.'));
        function calculaTotalProdutos(valorsubtotal, retirasubtotal){
            tvendas = valorsubtotal - retirasubtotal + tvendas;
            $('.totalitens').html(tvendas.toFixed(2).replace('.', ','));
            $('input[type=hidden][name=totalitens]').val(tvendas.toFixed(2).replace('.', ','));
            //atualizaTotal();
            calculaDesconto();
        }

        function atualizaTotal(){
            //recebe o totalprodutos e o desconto
            var totalp = parseFloat($('input[type=hidden][name=totalitens]').val().replace('.', '').replace(',', '.'));
            var descont = parseFloat($('#valor-desconto').val().replace('.', '').replace(',', '.'));
            $('#total').val((totalp - descont).toFixed(2).replace('.', ','));
            $('.total').html((totalp - descont).toFixed(2).replace('.', ','));
        }

        function calculaDesconto(){
            var descontop = $('#desconto').val();
            var tipodescontop = $('#tipo-desconto option:selected').val();
            if (tipodescontop === 'real'){
                $('#valor-desconto').val(descontop);
                $('.valor-desconto').html(descontop);
            }
            else if(tipodescontop === 'porcento'){
                var totalit = parseFloat($('.totalitens').html().replace('.', '').replace(',', '.')) / 100;
                if ($('#forma-pg-venda').val() == 'DINHEIRO+CARTAO'){
                    var total_valor_cartao = parseFloat($('#valor-cartao').val().replace('.', '').replace(',', '.'));
                    $('#valor-desconto').val((descontop * total_valor_cartao/100).toFixed(2).replace('.', ','));
                    $('.valor-desconto').html((descontop * total_valor_cartao/100).toFixed(2).replace('.', ','));
                }else {
                    $('#valor-desconto').val((descontop * totalit).toFixed(2).replace('.', ','));
                    $('.valor-desconto').html((descontop * totalit).toFixed(2).replace('.', ','));
                }
            }
            atualizaTotal();
        }

        function calculaParcelamento(){
            var totalpd = parseFloat($('#total').val().replace('.', '').replace(',', '.'));
            var parcela = $('#parcelas option:selected').val();
            $('.parcelavenda').html((totalpd / parcela).toFixed(2).replace('.', ','));
        }

        function calculaTroco(){
            var dinheiro = parseFloat($('#dinheiro').val().replace('.', '').replace(',', '.'));
            var total = parseFloat($('#total').val().replace('.', '').replace(',', '.'));
            $('#troco').val((dinheiro - total).toFixed(2).replace('.', ','));
            $('.troco').html((dinheiro - total).toFixed(2).replace('.', ','));
        }
        var qtditens = linhai - 1;
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
                //    $('input[type=hidden][name=ean]').attr('name', 'ean'+linhatabela);//.val(response.ean);
                //    $('.spanean').attr('class', 'spanean'+linhatabela);
                //    $('input[type=tel][name=preco-venda]').attr('name', 'preco'+linhatabela);//.val(response.preco_venda.toFixed(2).replace('.', ','));
                //    $('.spanun').attr('class', 'spanun'+linhatabela);//.html(response.unidade_medida);
                //    $('input[type=tel][name=qtd]').attr('name', 'qtd'+linhatabela);//.val(1);
                //    $('.spansubtotal').attr('class', 'spansubtotal'+linhatabela);
                //    $('input[type=hidden][name=un]').attr('name', 'un'+linhatabela);
                    linhai++;
                    $('input[type=hidden][name=ean'+linhatabela+']').val(response.ean);
                    $('.spanean'+linhatabela).html(response.ean);
                    $('input[type=tel][name=preco'+linhatabela+']').val(response.preco_venda.toFixed(2).replace('.', ','));
                    $('.spanun'+linhatabela).html(response.unidade_medida);
                    $('input[type=tel][name=qtd'+linhatabela+']').val(1);
                //    $('input[type=hidden][name=subtotal]').attr('name', 'subtotal'+linhatabela);
                    $('input[type=hidden][name=un'+linhatabela+']').val(response.unidade_medida);
                    $('#btn-send-venda').attr('disabled', false);
                    atualizasubtotal('qtd'+linhatabela, 'preco'+linhatabela, 'subtotal'+linhatabela);
                    $('#btn-add-table-row').attr('disabled', false);
                    pode_add_table_row = true;
                    $('#btn-qtd-linhai').html(++qtditens);
                    //debugger;
                    //console.log(slug);
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
            //var i = parseInt($('.item').html());
            var i = parseInt(linhai);
//            linhai++;
            var linhatabela = i;// + 1;
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
            cols += '<td><div style="width: 45px; overflow: auto;"><input type="tel" name="qtd'+linhatabela+'" onchange="atualizasubtotal(\'qtd'+linhatabela+'\', \'preco'+linhatabela+'\', \'subtotal'+linhatabela+'\');" required></div></td>';
            cols += '<td><span class="spansubtotal'+linhatabela+'"></span><input type="hidden" name="subtotal'+linhatabela+'" id="subtotal'+linhatabela+'" value="0"></td>';

            cols += '<td>';
            cols += '<button onclick="RemoveTableRow(this, \'subtotal'+linhatabela+'\')" type="button" class="btn-floating waves-effect red"><i class="tiny material-icons">clear</i></button>';
            cols += '</td>';

            newRow.append(cols);
            $("#products-table").append(newRow);
            $('#btn-send-venda').attr('disabled', true);
            $('#btn-add-table-row').attr('disabled', true);
            pode_add_table_row = false;
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

            calculaTotalProdutos(0, subtotalvendas);
            $('#btn-send-venda').attr('disabled', false);
            $('#btn-add-table-row').attr('disabled', false);
            pode_add_table_row = true;
            if (subtotalvendas > 0.00)
                $('#btn-qtd-linhai').html(--qtditens);
            return false;
            }
        })(jQuery);

        calculaDesconto();
        calculaParcelamento();

        $('#leitor-ean').keypress(function (event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            var linha_do_item = parseInt(linhai);
	        if(keycode == '13'){
                var cod_ean = $('#leitor-ean').val();
                var qtdproduto = 1;
                $.ajax({
                    url: "/erp/produtos/cod-barras/"+cod_ean,
                    type: 'GET',
                    //data: $('#form-itemtable').serialize(),//{slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response, status) {
                        if (status === 'success'){
                            if (pode_add_table_row) AddTableRow();
                            linhai++;
                            $('#'+linha_do_item).val(response.descricao);
                            $('input[type=hidden][name=ean'+linha_do_item+']').val(response.ean);
                            $('.spanean'+linha_do_item).html(response.ean);
                            $('input[type=tel][name=preco'+linha_do_item+']').val(response.preco_venda.toFixed(2).replace('.', ','));
                            $('.spanun'+linha_do_item).html(response.unidade_medida);
                            if (response.unidade_medida == "KG" & cod_ean.length == 13 & cod_ean[0] == 2)
                                qtdproduto = parseFloat(getQtdPorEan(cod_ean).substr(0, 2)+'.'+getQtdPorEan(cod_ean).substr(2, 3)).toFixed(3);
                            else
                                qtdproduto = parseInt(getQtdPorEan(cod_ean));
                            $('input[type=tel][name=qtd'+linha_do_item+']').val(qtdproduto);
                            $('input[type=hidden][name=un'+linha_do_item+']').val(response.unidade_medida);
                            $('#btn-send-venda').attr('disabled', false);
                            atualizasubtotal('qtd'+linha_do_item, 'preco'+linha_do_item, 'subtotal'+linha_do_item);
                            $('#btn-add-table-row').attr('disabled', false);
                            pode_add_table_row = true;
                            $('#btn-qtd-linhai').click();
                            $('#btn-qtd-linhai').html(++qtditens);
                        }else if (status === 'nocontent')
                            msgtela('Produto inexistente');
                        //debugger;
                        console.log(status);
                        console.log(response);
                    }
                });
                $('#leitor-ean').val('');
	        }
        });

        function getQtdPorEan(codigo){
            if (codigo[0] == 2) return codigo.substr(7, 5);
            else return 1;
        }

        function calculaTotalDinheiroCartao(){
            var valor_cartao = parseFloat($('#valor-cartao').val().replace('.', '').replace(',', '.'));
            var desconto_porcento = parseFloat($('#desconto').val().replace('.', '').replace(',', '.'))/100;
            var total_itens = parseFloat($('.totalitens').html().replace('.', '').replace(',', '.'))
            $('#valor-desconto').val((valor_cartao * desconto_porcento).toFixed(2).replace('.', ','));
            $('.valor-desconto').html((valor_cartao * desconto_porcento).toFixed(2).replace('.', ','));
            $('#total').val((total_itens- valor_cartao * desconto_porcento).toFixed(2).replace('.', ','));
            $('.total').html((total_itens- valor_cartao * desconto_porcento).toFixed(2).replace('.', ','));
            $('#dinheiro').val((total_itens- valor_cartao * desconto_porcento - valor_cartao).toFixed(2).replace('.', ','));
        }

        $('#forma-pg-venda').change(function (){
            if ($('#forma-pg-venda').val() == 'DINHEIRO+CARTAO') habilitaDinheiroCartao(false, false);
            else habilitaDinheiroCartao(false, true);
        });

        function habilitaDinheiroCartao(habdinheiro, habcartao){
            $('#dinheiro').attr('disabled', habdinheiro);
            $('#valor-cartao').val(0).attr('disabled', habcartao);
        }
    </script>
@endsection