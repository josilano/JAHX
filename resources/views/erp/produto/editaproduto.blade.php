@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">EDITAR PRODUTO</h3>
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

    <div class="col l3 m3 s4 yellow-text text-accent-4">
        <a href="{{ route('jahx.produtos') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons indigo-text text-darken-4 waves-effect">shopping_basket</i>
            PRODUTOS
        </a>
    </div>
    <br><br>
    @if(isset($produto))
        <div class="col l12 m12 s12">
            <form id="form-update-produto" action="{{ route('jahx.atualizaproduto', ['id' => $produto->id]) }}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                
                <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600; border-width: 4px;" class="black">
                <legend class="yellow accent-4">Editar Produto</legend>

                <div class="row">
                    <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                        <i class="material-icons yellow-text text-accent-4 prefix">label_outline</i>
                        <input required type="text" id="descricao" name="descricao" maxlength="60" data-length="60" value="{{ $produto->descricao }}">
                        <label for="descricao">Descrição</label>
                    </div>
                        
                    <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                        <i class="material-icons yellow-text prefix">loyalty</i>
                        <select id="marca" name="marca" required>
                            <option value="{{ $produto->marca }}" selected>{{ $produto->marca }}</option>
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
                            <option value="{{ $produto->unidade_medida }}" selected>{{ $produto->unidade_medida }}</option>
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
                        <input required type="tel" id="ean" name="ean" maxlength="14" data-length="14" value="{{ $produto->ean }}">
                        <label for="ean">EAN/Código de Barra</label>
                    </div>
                    <div class="input-field col s12 m4 l4 yellow-text text-accent-4">
                        <i class="material-icons yellow-text text-darken-3 prefix">attach_money</i>
                        <input type="tel" required="required" maxlength="12" id="preco-venda" name="preco-venda"
                            onKeyUp="maskIt(this,event,'###.###.###,##',true)" value="{{ number_format($produto->preco_venda, 2, ',', '.') }}">
                        <label for="preco-venda">Preço de Venda</label>
                    </div>
                    <div class="input-field col s12 m4 l4 yellow-text text-accent-4">
                        <i class="material-icons yellow-text text-accent-4 prefix">warning</i>
                        <input type="tel" id="qtd-minima" name="qtd-minima" maxlength="4" data-length="4" value="{{ $produto->qtd_minima }}">
                        <label for="qtd-minima">Quantidade Mínima pro Estoque</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                        <i class="material-icons prefix">bookmark_border</i>
                        <select id="id-categoria" name="id-categoria" required>
                            <option value="{{ $produto->id_categoria }}" selected>{{ $produto->id_categoria }}</option>
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
                <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit" name="action">Atualizar Produto
                    <i class="material-icons right black-text">send</i>
                </button>
            </form>
        </div>
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

    @if(isset($produtoexception))
        @include('erp.partials.msgexception', ['exception' => $produtoexception])
    @endif

    @if(isset($upprodexception))
        @include('erp.partials.msgexception', ['exception' => $upprodexception])
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
    @if(is_null($produto))
        <script type="text/javascript">
            //var testemsg = $('#id-teste').val();
            msgtela('produto inexistente');
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
    @if(isset($upprod))
        @if(!is_numeric($upprod))
        <script type="text/javascript">
            msgtela('Produto atualizado');
        </script>
        @endif
    @else
        <script type="text/javascript">
            msgtela('Erro na atualização');
        </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function() {
            $('#marca').material_select();
            $('#un').material_select();
            $('#id-categoria').material_select();
            //$('#modal1').modal('open');
            
        });
    </script>

    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
@endsection