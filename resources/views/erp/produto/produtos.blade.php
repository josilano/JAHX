@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">PRODUTOS</h3>
        <table class="highlight yellow-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Produtos Cadastrados</td>
                    <td>@if(isset($produtos)){{ $produtos->total() }}@endif</td>
                </tr>
            </tbody>
        </table>
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
    <div class="row">
        <div class="col s12">
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">search</i>
              <input type="text" id="autocomplete-input" class="autocomplete">
              <label for="autocomplete-input">Buscar</label>
            </div>
          </div>
        </div>
    </div>

    <ul class="collapsible" data-collapsible="accordion">
        <li>
            <div class="collapsible-header yellow accent-4"><i class="material-icons">filter_drama</i>Cadastrar Produto</div>
            <div class="collapsible-body black">
                <form id="form-create-veiculo" action="{{ route('jahx.addproduto') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600;">
                    <legend class="purple-text text-darken-3 yellow-text text-accent-4">Dados do Produto</legend>
                    <div class="row">
                        <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                            <i class="material-icons yellow-text text-accent-4 prefix">label_outline</i>
                            <input required type="text" id="descricao" name="descricao" maxlength="60" data-length="60">
                            <label for="descricao">Descrição</label>
                        </div>
                        
                        <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                            <i class="material-icons yellow-text prefix">loyalty</i>
                            <select id="marca" name="marca" required>
                                <option value="" disabled selected>Selecione a Marca</option>
                                @if(isset($marcas))
                                @foreach($marcas as $marca)
                                <option value="{{ $marca->nome_marca }}">{{ $marca->nome_marca }}</option>
                                @endforeach
                                @endif
                            </select>
                            <label>Marca</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                            <i class="material-icons prefix">polymer</i>
                            <select id="un" name="un" required>
                                <option value="" disabled selected>Selecione a Unidade de Medida</option>
                                @if(isset($unmedidas))
                                @foreach($unmedidas as $un)
                                <option value="{{ $un->sigla }}">{{ $un->descricao }}</option>
                                @endforeach
                                @endif
                            </select>
                            <label>Unidade de Medida</label>
                        </div>
                        <div class="input-field col s12 m4 l4 yellow-text text-accent-4">
                            <i class="fa fa-barcode fa-2x yellow-text text-accent-4 prefix" aria-hidden="true"></i>
                            <input required type="tel" id="ean" name="ean" maxlength="14" data-length="14">
                            <label for="ean">EAN/Código de Barra</label>
                        </div>
                        <div class="input-field col s12 m4 l4 yellow-text text-accent-4">
                            <i class="material-icons yellow-text text-darken-3 prefix">attach_money</i>
                            <input type="tel" required="required" maxlength="12" id="preco-venda" name="preco-venda"
                                onKeyUp="maskIt(this,event,'###.###.###,##',true)">
                            <label for="preco-venda">Preço de Venda</label>
                        </div>
                        <div class="input-field col s12 m4 l4 yellow-text text-accent-4">
                            <i class="material-icons yellow-text text-accent-4 prefix">warning</i>
                            <input type="tel" id="qtd-minima" name="qtd-minima" maxlength="4" data-length="4" value="20">
                            <label for="qtd-minima">Quantidade Mínima pro Estoque</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                            <i class="material-icons prefix">bookmark_border</i>
                            <select id="id-categoria" name="id-categoria" required>
                                <option value="" disabled selected>Selecione a Categoria</option>
                                @if(isset($categorias))
                                @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome_categoria }}</option>
                                @endforeach
                                @endif
                            </select>
                            <label>Categoria</label>
                        </div>
                    </div>
                </fieldset>
                <br>
                <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit" name="action">Cadastrar Produto
                    <i class="material-icons right black-text">send</i>
                </button>
                </form>

            </div>
        </li>
    </ul>
    <a class="btn-large purple" href="{{ route('jahx.detalheproduto') }}">Lista Últimos Preços de Compras de Produtos</a>

        @if(isset($produtos))
    
        <ul class="collapsible" data-collapsible="accordion">
            @foreach($produtos as $produto)
            <li>
                <div class="collapsible-header"><i class="material-icons yellow-text text-accent-4 prefix">label_outline</i>{{ $produto->descricao }} @if ($produto->qtd < $produto->qtd_minima)<span class="new badge red" data-badge-caption="em falta">{{ $produto->qtd_minima - $produto->qtd }}</span>@endif</div>
                <div class="collapsible-body">
                    <div class="row">
                        <div class="col s3 m3 l3 cyan-text text-accent-4">
                            <i class="material-icons red-text text-lighten-1 prefix">loyalty</i>
                            {{ $produto->marca }}
                        </div>
                        <div class="col s3 m3 l3 cyan-text text-accent-4">
                            <i class="material-icons purple-text text-lighten-4 prefix">polymer</i>
                            {{ $produto->unidade_medida }}
                        </div>
                        <div class="col s3 m3 l3 cyan-text text-accent-4">
                            <i class="fa fa-archive purple-text prefix" aria-hidden="true"></i>
                            {{ $produto->qtd }}
                        </div>
                        <div class="col s3 m3 l3 cyan-text text-accent-4">
                            <i class="fa fa-archive purple-text prefix" aria-hidden="true"></i>
                            {{ $produto->qtd_minima }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s4 m4 l4 cyan-text text-accent-4">
                            <i class="fa fa-id-card purple-text text-darken-3 prefix" aria-hidden="true"></i>
                            {{ $produto->id }}
                        </div>
                        <div class="col s4 m4 l4 cyan-text text-accent-4">
                            <i class="fa fa-barcode fa-2x black-text prefix" aria-hidden="true"></i>
                            {{ $produto->ean }}
                        </div>
                        <div class="col s4 m4 l4 cyan-text text-accent-4">
                            <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                            {{ number_format($produto->preco_venda, 2, ',', '.') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l6 m6 s12 center-align yellow lighten-5">
                            <i class="material-icons red-text">mode_edit</i>
                            <a class="" href="{{ route('jahx.mostraproduto', ['id' => $produto->id]) }}">Editar</a>
                        </div>
                        <div class="col l6 m6 s12 center-align yellow lighten-5">
                            <i class="material-icons red-text">delete</i>
                            <a class="" href="#modal-confirma-delete" onclick="getProdutoIdToExcluir({{ $produto->id }});">Excluir</a>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <div id="modal-confirma-delete" class="modal">
            <div class="modal-content">
                <h4>Muita calma nessa hora</h4>
                <p class="purple-text">REALMENTE DESEJA EXLUIR O PRODUTO?</p>
                <p>Se houver compras com esse danado e vc papocar ele, poderá causar erros na exibição das compras, vulgo erro de confacstação de busterfly</p>
            </div>
            <div class="modal-footer">
                <a href="#!" onclick="$('#modal-confirma-delete').modal('close');">Não excluir</a>
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="excluirProduto();">Papocar com linha, carretel e tudo</a>
            </div>
        </div>

        @include('erp.partials.componentepaginacao', ['paginacao' => $produtos])
        
        @endif
    
@endsection

@section('rodape')
    @if(isset($marcasexception))
        @include('erp.partials.msgexception', ['exception' => $marcasexception])
    @endif

    @if(isset($unmedidasexception))
        @include('erp.partials.msgexception', ['exception' => $unmedidasexception])
    @endif

    @if(isset($categoriasexception))
        @include('erp.partials.msgexception', ['exception' => $categoriasexception])
    @endif

    @if(isset($produtosexception))
        @include('erp.partials.msgexception', ['exception' => $produtosexception])
    @endif

    @if(isset($cadprodexception))
        @include('erp.partials.msgexception', ['exception' => $cadprodexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        //var testemsg = $('#id-teste').val();
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);//'sem cadastro de produtos', 4000);
        }
        //jsteste(testemsg);
    </script>
    @if(is_null($produtos))
        <script type="text/javascript">
            //var testemsg = $('#id-teste').val();
            msgtela('sem cadastro de produtos');
        </script>
    @endif
    
    @if(is_null($marcas))
        <script type="text/javascript">
            msgtela('sem cadastro de marcas');
        </script>
    @endif
    @if(is_null($unmedidas))
        <script type="text/javascript">
            msgtela('sem cadastro de unidades de medidas');
        </script>
    @endif
    @if(is_null($categorias))
        <script type="text/javascript">
            msgtela('sem cadastro de categorias');
        </script>
    @endif
    @if(isset($cadprod))
        @if(!is_numeric($cadprod))
        <script type="text/javascript">
            msgtela('Produto cadastrado');
        </script>
        @endif
    @else
        <script type="text/javascript">
            msgtela('Erro no cadastro');
        </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function() {
            $('input.autocomplete').autocomplete({
            data: {
              @foreach($produtosall as $produto)
              "{{ $produto->descricao }}": null,
              @endforeach
            },
            limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
            onAutocomplete: function(slug) {
                // Callback function when value is autcompleted.

                $.ajax({
                    //url: "{{ route('jahx.mostraprodutodescricao', ['' => 'ovo']) }}",
                    url: "/erp/produtos/q="+slug,
                    type: 'GET',
                    //data: {slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        window.location.replace("/erp/produtos/q="+slug);
                        //debugger;
                        console.log(slug);
                    }
                });
            },
            minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
          });
        });
        var produto_id = null;
        function getProdutoIdToExcluir(id){
            produto_id = id;
        }

        function excluirProduto(){
            if (produto_id == null) msgtela('Nao pode exlcuir produto sem identificacao');
            else {
                $.ajax({
                    url: "/erp/produtos/"+produto_id,
                    type: 'DELETE',
                    data: {"_token": "{{ csrf_token() }}" },
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        window.location.replace("/erp/produtos");
                        //debugger;
                        msgtela('Produto Excluído');
                        console.log(response);
                    },
                    error: function (response){
                        window.location.replace("/erp/produtos");
                        console.log(response);
                    }
                    
                });
            }
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