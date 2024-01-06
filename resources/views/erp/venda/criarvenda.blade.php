@extends('erp.template.templateerp')

@section('title', 'JahX Iniciar Venda')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="amber-text text-accent-4 center-align">INICIAR VENDA</h3>
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
        <a href="{{ route('jahx.vendas') }}" class="amber-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons waves-effect blue-text">shopping_cart</i>
            VENDAS
        </a>
    </div>
    <br><br>

    <h5 class="center-align amber-text text-accent-4 black">Selecione o cliente</h5>
    @include ('erp.partials.componenteautocomplete')

    @include ('erp.partials.clientes.componentemostraumcliente', ['cliente' => $cliente])

    <h5 class="center-align amber-text text-accent-4 black">Selecione os produtos</h5>
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
    <!--<div class="row">
      <div class="col s12">
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix">search</i>
            <input type="text" id="product" class="autocomplete">
            <label for="product">Buscar produtos</label>
          </div>
        </div>
      </div>
    </div> uma busca para inserir os produtos -->

    <!--<input type="tel" name="ean" id="ean">
    <input type="text" name="descricao" id="descricao">
    <input type="tel" name="preco-venda" id="preco-venda" onchange="atualizasubtotal();" onKeyUp="maskIt(this,event,'###.###.###,##',true)">
    <input type="text" name="qtd" id="qtd" onchange="atualizasubtotal();">
    <input type="tel" name="subtotal" id="subtotal" onchange="maskIt(this,event,'###.###.###,##',true)">-->

    <div class="table-container">
        <form action="{{ route('jahx.addvenda') }}" method="post" id="form-create-venda">
            {{ csrf_field() }}
            <input type="hidden" name="id-cliente" value="1">
            <input type="hidden" name="id-usuario" value="{{ Auth::user()->id }}">
            <input type="hidden" name="setor-venda" value="erp">
            @include ('erp.partials.componenteitensprodutos')
            <div class="row scrollspy" id="btn-spy">
                <div class="col l2 m4 s12 offset-l4 offset-m4">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Total Produtos</legend>
                        <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
                        <input type="hidden" name="totalitens" id="totalitens">
                        <span class="totalitens"></span>
                    </fieldset>
                </div>
                <div class="col l4 m4 s12">
                    <div class="row">
                        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Desconto</legend>
                            <div class="input-field col s12 m3 l3">
                                <select name="tipo-desconto" id="tipo-desconto" onchange="calculaDesconto()">
                                    <option value="real" selected>R$</option>
                                    <option value="porcento">%</option>
                                </select>        
                            </div>

                            <div class="input-field col s12 m7 l7">
                                <i class="material-icons amber-text text-accent-4 prefix">money_off</i>
                                <input type="tel" id="desconto" name="desconto" maxlength="6" data-length="6" onchange="calculaDesconto()" value="0">
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
                        <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
                        <input type="hidden" name="total" id="total">
                        <span class="total"></span>
                    </fieldset>
                </div>
                <div class="col l6 m6 s6">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Forma de Pagamento</legend>
                        <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
                        <?php $formapgs = FormaPagamentoFacade::all(); ?>
                        <select id="forma-pg-venda" name="forma-pg-venda">
                            <option value="DINHEIRO" selected>DINHEIRO</option>
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
                                <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
                                <select id="parcelas" name="parcelas" onchange="calculaParcelamento()">
                                    <option value="1" selected>1</option>
                                    @for($i = 2; $i < 11; $i++)
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
            @include ('erp.partials.componentedinheirotroco')
            <div class="divider"></div>
            
            <button class="btn waves-effect waves-light amber accent-4 black-text" id="btn-send-venda" type="submit">Finalizar Venda
                <i class="material-icons right black-text">send</i>
            </button>
        </form>
    </div>
    
@endsection

@section('rodape')
    @if(isset($vendasexception))
        @include('erp.partials.msgexception', ['exception' => $vendasexception])
    @endif

    @if(isset($cadvendaexception))
        @include('erp.partials.msgexception', ['exception' => $cadvendaexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#btn-send-venda').attr('disabled', true);
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
            $('#autocomplete-input').autocomplete({
            data: {
              @foreach($clientesall as $cliente)
              "{{ $cliente->nome_rsocial }}": null,
              "{{ $cliente->nome_fantasia }}": null,
              @endforeach
            },
            limit: 20,
            onAutocomplete: function(slug) {
                $.ajax({
                    url: "/erp/clientes/nome/"+slug,
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
                        $('.linkeditarcliente').attr('href', '/erp/clientes/'+response.id);
                        $('input[type=hidden][name=id-cliente]').val(response.id);
                        $('#autocomplete-input').val('');
                        //debugger;
                        //console.log(slug);
                    }
                });
            },
            minLength: 1,
          });

        
            $('#3').autocomplete({
            data: {
              @foreach($produtos as $produto)
              "{{ $produto->descricao }}": null,
              @endforeach
            },
            limit: 20,
            onAutocomplete: function(descricao) {
            $.ajax({
                    url: "/erp/itemprodutos/tabela/"+descricao,
                    type: 'GET',
                    //data: $('#form-itemtable').serialize(),//{slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        //$('div.table-container').fadeOut();
                        $('div.table-container').html(response.html);//.load(response, function(){
                            //$('div.table-container').fadeIn();
                        //});
                        atualizasubtotal('1');
                        $('#product').val('');
                        //debugger;
                        //console.log(slug);
                    }
                });
        
/* utilizado para renderizar uma tabela dos itens selecionados
            $('#product').autocomplete({
            data: {
              @foreach($produtos as $produto)
              "{{ $produto->descricao }}": null,
              @endforeach
            },
            limit: 20,
            onAutocomplete: function(descricao) {
            $.ajax({
                    url: "/erp/itemprodutos/tabela/"+descricao,
                    type: 'GET',
                    //data: $('#form-itemtable').serialize(),//{slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        //$('div.table-container').fadeOut();
                        $('div.table-container').html(response.html);//.load(response, function(){
                            //$('div.table-container').fadeIn();
                        //});
                        atualizasubtotal('1');
                        $('#product').val('');
                        //debugger;
                        //console.log(slug);
                    }
                }); */

            /*    $.ajax({
                    url: "/erp/produtos/descricao/"+slug,
                    type: 'GET',
                    //data: {slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        $('#ean').val(response.ean);
                        $('input[type=text][name=descricao]').val(response.descricao);
                        //$('input[type=text][name=descricao]').val(response.descricao);
                        $('input[type=tel][name=preco-venda]').val(response.preco_venda.toFixed(2).replace('.', ','));
                        $('input[type=text][name=qtd]').val('1');
                        atualizasubtotal();
                        $('div.table-container').fadeOut();
                        $('div.table-container').load("url", function(){
                            $('div.table-container').fadeIn();
                        });
                        $('#product').val('');
                        //window.location.replace("/erp/vendas/q="+slug);
                        //debugger;
                        //console.log(slug);
                    }
                });*/
            },
            minLength: 1,
          });
        });
        function atualizasubtotal(iqtd, ipreco, isubtotal) {
            //$('input[type=text][name=qtd]').on('change', function(){
            var qtd = parseFloat($('input[type=tel][name='+iqtd+']').val().replace(',', '.'));
            var preco = parseFloat($('input[type=tel][name='+ipreco+']').val().replace('.', '').replace(',', '.'));
            var ean = parseInt($('input[type=hidden][name=ean'+iqtd.replace('qtd', '')+']').val());
            if (!Number.isNaN(qtd) & !Number.isNaN(preco) & !Number.isNaN(ean)){
                var subtotal = qtd * preco;
                var decrementasubtotal = parseFloat($('input[type=hidden][name='+isubtotal+']').val().replace('.', '').replace(',', '.'));
                $('.span'+isubtotal).html(subtotal.toFixed(2).replace('.', ','));
                $('input[type=hidden][name='+isubtotal+']').val(subtotal.toFixed(2).replace('.', ','));//.toString().replace(/([0-9]{3}).([0-9]{3}),([0-9]{2}$)/g, ".$1.$2,$3"));
                calculaTotalProdutos(subtotal, decrementasubtotal);
            }
        }
        var qtditens = parseInt(0);
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
var tvendas = 0.00;
        function calculaTotalProdutos(valorsubtotal, retirasubtotal){
            tvendas = valorsubtotal - retirasubtotal + tvendas;
            //for (var i = linhai; i > 0; i--) {
            //    if (typeof $('.spansubtotal'+i) !== null || typeof $('.spansubtotal'+i) !== 'undefined'){
            //        alert($('.spansubtotal'+i));
            //        tvendas = parseFloat($('.spansubtotal'+i).html().replace('.', '').replace(',', '.')) + tvendas;
            //    }
            //}
            $('.totalitens').html(tvendas.toFixed(2).replace('.', ','));
            $('input[type=hidden][name=totalitens]').val(tvendas.toFixed(2).replace('.', ','));
            atualizaTotal();
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
                $('#valor-desconto').val((descontop * totalit).toFixed(2).replace('.', ','));
                $('.valor-desconto').html((descontop * totalit).toFixed(2).replace('.', ','));
            }
            atualizaTotal();
        }

        function atualizaTotal(){
            //recebe o totalprodutos e o desconto
            var totalp = parseFloat($('input[type=hidden][name=totalitens]').val().replace('.', '').replace(',', '.'));
            var descont = parseFloat($('#valor-desconto').val().replace('.', '').replace(',', '.'));
            $('#total').val((totalp - descont).toFixed(2).replace('.', ','));
            $('.total').html((totalp - descont).toFixed(2).replace('.', ','));
            $('#dinheiro').val($('#total').val());
        }

        function calculaParcelamento(){
            var totalpd = parseFloat($('#total').val().replace('.', '').replace(',', '.'));
            var parcela = $('#parcelas option:selected').val();
            $('.parcelavenda').html((totalpd / parcela).toFixed(2).replace('.', ','));
        }

        function calculaTroco(){
            var dinheiro = parseFloat($('#dinheiro').val().replace('.', '').replace(',', '.'));
            var total = parseFloat($('#total').val().replace('.', '').replace(',', '.'));
            if ($('#forma-pg-venda').val() == 'DINHEIRO+CARTAO'){
                var vc = parseFloat($('#valor-cartao').val().replace('.', '').replace(',', '.'));
                $('#troco').val((vc + dinheiro - total).toFixed(2).replace('.', ','));
                $('.troco').html((vc + dinheiro - total).toFixed(2).replace('.', ','));
            }else {
                $('#troco').val((dinheiro - total).toFixed(2).replace('.', ','));
                $('.troco').html((dinheiro - total).toFixed(2).replace('.', ','));
            }
        }

var linhai = 1;
var pode_add_table_row = false;
        (function($) {
            AddTableRow = function() {

            var newRow = $("<tr>");
            var cols = "";
            //var i = parseInt($('.item').html());
            var i = parseInt(linhai);
            //linhai++;
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

        //metodo remocao de linha da tabela, obs: n testado
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
            //if ($('#forma-pg-venda').val() == 'CARTÃO DE CRÉDITO') habilitaDinheiroCartao(true, false);
            //else if ($('#forma-pg-venda').val() == 'CARTÃO DE DÉBITO') habilitaDinheiroCartao(true, false);
            //else if ($('#forma-pg-venda').val() == 'DINHEIRO+CARTAO') habilitaDinheiroCartao(false, false);
            else habilitaDinheiroCartao(false, true);
        });

        function habilitaDinheiroCartao(habdinheiro, habcartao){
            $('#dinheiro').attr('disabled', habdinheiro);
            $('#valor-cartao').val(0).attr('disabled', habcartao);
        }
    </script>

    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
@endsection