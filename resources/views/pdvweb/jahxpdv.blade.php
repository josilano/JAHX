@extends('pdvweb.templatepdv.templatepdvweb')

@section('title', 'JahX PDV')

@section('contentpdv')
    <div class="row">
        <div class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">search</i>
                <input type="text" id="produtopdv" class="autocomplete" onclick="pegaproduto()" name="descricao1" autofocus>
                <label for="autocomplete-input">Seleciona Produto</label>
              </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col l4 offset-l8 m4 offset-m8 s12 cyan-text">
            <fieldset style="border-radius: 20px; border-color: #ffd600;">
                <legend class="purple-text text-darken-3 yellow-text text-accent-4">Subtotal</legend>
                <span class="spansubtotal" style="font-size: 30px;">R$ 0,00</span>
                <input type="hidden" name="subtotal" value="0">
            </fieldset>
        </div>

        <div class="divider col l12 m12 s12"></div>

        <div class="col l8 m8 s12">
            <h6>Produto selecionado</h6>
        </div>
        <div class="col l6 m6 s12 cyan-text">
            <span class="spandescricao">descrição</span><input type="hidden" name="descricao">
        </div>

        <div class="col l6 m6 s12 cyan-text">
            <span class="spanean">ean</span><input type="hidden" name="ean"><input type="hidden" name="idproduto">
        </div>

        <div class="col l6 m6 s12 cyan-text">
            <span class="spanun">un</span><input type="hidden" name="un">
        </div>

        <div class="col l4 m4 s12 cyan-text">
            <fieldset style="border-radius: 20px; border-color: #ffd600;">
                <legend class="purple-text text-darken-3 yellow-text text-accent-4">Total Item</legend>
                <span class="spantotalitem" style="font-size: 30px;">0,00</span>
                <input type="hidden" name="totalitem" value="0">
            </fieldset>
        </div>

        <form action="{{ route('jahx.insereitempdv', ['id' => 1]) }}" method="get" id="form-create-item-table">
            {{ csrf_field() }}
            <div class="col l4 m4 s12">
                <fieldset style="border-radius: 20px; border-color: #ffd600;">
                    <legend class="purple-text text-darken-3 yellow-text text-accent-4">QTD</legend>
                    <input type="tel" name="qtd" onchange="atualizatotalitem('qtd', 'preco', 'subtotal');" style="font-size: 30px;">
                </fieldset>
            </div>

            <div class="col l4 m4 s12">
                <fieldset style="border-radius: 20px; border-color: #ffd600;">
                    <legend class="purple-text text-darken-3 yellow-text text-accent-4">Preço</legend>
                    <input type="tel" name="preco-venda" onchange="atualizatotalitem('qtd', 'preco', 'subtotal');" onKeyUp="maskIt(this,event,'###.###.###,##',true)" style="font-size: 30px;">
                </fieldset>
            </div>
        </form>

        <div class="col l6 m6 s12">
            <a class="waves-effect waves-light btn-flat cyan-text" href="#" onclick="incluiItem();"><i class="material-icons left">cloud</i>incluir</a>
            <a class="waves-effect waves-light btn-flat cyan-text" href="#" onclick="cancelavenda();"><i class="material-icons left">cloud</i>cancelar venda</a>
        </div>
    </div>
    
    <div class="fixed-action-btn horizontal click-to-toggle">
        <a class="btn-floating btn-large red">
            <i class="material-icons">menu</i>
        </a>
        <ul>
            <li class="center-align"><span>cancela item</span><br><a class="btn-floating red"><i class="material-icons">insert_chart</i>cancela item</a></li>
            <li class="center-align"><span>cancela venda</span><br><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
            <li class="center-align"><span>finalizar venda</span><br><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
            <li class="center-align"><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
        </ul>
    </div>
        
    
@endsection

@section('telapdv')
    @include('erp.partials.componenteautocomplete')
    <label>nome/ razão social</label><label>cpf/ cnpj</label>

    <div class="table-container"></div>
@endsection

@section('cabecalho')
    código teste para impressão direta na impressora termica com php
    <?php    
        //$handle = printer_open("HP Deskjet 930c");  // http://php.net/manual/pt_BR/function.printer-open.php
    //    $handle = printer_open();

    //    printer_start_doc($handle, "Document name");        
    //    printer_start_page($handle); // Start page 1
        // here goes the content of page 1 via printer_write
    //    printer_write($handle, "A37,503,0,1,2,3,N,PRINTED USING PHP\n");
    //    printer_end_page($handle); // Close page 1

        //printer_start_page($handle); // Start page 2
        // here goes the content of page 2 via printer_write
        //printer_end_page($handle); // Close page 2

    //    printer_end_doc($handle);
    //    printer_close($handle);
    ?>
@endsection

@section('navigation')
    <h1 class="center-align white-text">Pi Flamewed</h1>

@endsection

@section('content')
    
@endsection

@section('rodape')
    
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#autocomplete-input').autocomplete({
            data: {
              @foreach($clientes as $cliente)
              "{{ $cliente->nome_rsocial }}": null,
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
            $(document).keypress(function(e){
                if(e.wich == 119 || e.keyCode == 119){
                    //alert('A tecla ENTER foi pressionada');
                    cancelavenda();
                }
            })

        });
        function atualizatotalitem() {
            var qtd = parseInt($('input[type=tel][name=qtd]').val());
            var preco = parseFloat($('input[type=tel][name=preco-venda]').val().replace('.', '').replace(',', '.'));
            var subtotal = qtd * preco;
            var decrementasubtotal = parseFloat($('input[type=hidden][name=subtotal]').val().replace('.', '').replace(',', '.'));
            $('.spantotalitem').html(subtotal.toFixed(2).replace('.', ','));
            $('input[type=hidden][name=totalitem]').val(subtotal.toFixed(2).replace('.', ','));
            //$('.spansubtotal').html(subtotal.toFixed(2).replace('.', ','));
            //$('input[type=hidden][name=subtotal]').val(subtotal.toFixed(2).replace('.', ','));
            //calculaTotalProdutos(subtotal, decrementasubtotal);
        }

        function pegaproduto(){
            $('#produtopdv').autocomplete({
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
                        $('.spandescricao').html(response.descricao);
                        $('input[type=hidden][name=descricao]').val(response.descricao);
                        $('input[type=hidden][name=ean]').val(response.ean);
                        $('input[type=hidden][name=idproduto]').val(response.id);
                        $('.spanean').html(response.ean);
                        $('.spanun').html(response.unidade_medida);
                        $('input[type=hidden][name=un]').val(response.unidade_medida);
                        $('input[type=tel][name=preco-venda]').val(response.preco_venda.toFixed(2).replace('.', ','));
                        $('input[type=tel][name=qtd]').val(1);
                        $('#produtopdv').val('');
                        //$('input[type=hidden][name=subtotal]').attr('name', 'subtotal'+linhatabela);
                        $('input[type=tel][name=qtd]').focus();
                        atualizatotalitem();
                        
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
        }

        function calculaParcelamento(){
            var totalpd = parseFloat($('#total').val().replace('.', '').replace(',', '.'));
            var parcela = $('#parcelas option:selected').val();
            $('.parcelavenda').html((totalpd / parcela).toFixed(2).replace('.', ','));
        }

        function incluiItem(){
            var idproduto = $('input[type=hidden][name=idproduto]').val();
            $.ajax({
                    url: "/erp/itemprodutos/"+idproduto,
                    type: 'GET',
                    data: $('#form-create-item-table').serialize(),//{slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        $('div.table-container').html(response.html);

                        atualizasubtotal();
                        $('.spantotalitem').html('0,00');
                        $('input[type=tel][name=qtd]').val('');
                        $('input[type=tel][name=preco-venda]').val('');
                        $('.spandescricao').html('');
                        $('.spanean').html('');
                        $('.spanun').html('');
                        $('#produtopdv').focus();
                        
                        //debugger;
                        //console.log(response);
                    }
            });
        }

        function atualizasubtotal() {
            var totalitem = parseFloat($('.spantotalitem').html().replace('.', '').replace(',', '.'));// 
            tvendas = totalitem + tvendas;
            $('.spansubtotal').html(tvendas.toFixed(2).replace('.', ','));
        }

        function cancelavenda(){
            $.ajax({
                    url: "/erp/itemprodutos/cancelamento/pdv",
                    type: 'GET',
                    //data: $('#form-create-item-table').serialize(),//{slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        $('div.table-container').html('');
                        tvendas = 0.00;
                        $('.spansubtotal').html(tvendas.toFixed(2).replace('.', ','));
                        $('.spantotalitem').html(tvendas.toFixed(2).replace('.', ','));
                        $('input[type=tel][name=qtd]').val('');
                        $('input[type=tel][name=preco-venda]').val('');
                        $('.spandescricao').html('');
                        $('.spanean').html('');
                        $('.spanun').html('');
                        //atualizasubtotal();
                        
                        //debugger;
                        //console.log(response);
                    }
            });
        }
    </script>
@endsection