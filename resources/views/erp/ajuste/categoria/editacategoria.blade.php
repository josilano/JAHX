@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">EDITAR CATEGORIA</h3>
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
        <a href="{{ route('jahx.categorias') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons purple-text waves-effect">settings</i>
            CATEGORIAS
        </a>
    </div>

    <br><br>
    @if(isset($categoria))
        <div class="col l12 m12 s12">
            <form id="form-update-categoria" action="{{ route('jahx.atualizacategoria', ['id' => $categoria->id]) }}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                
                <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600; border-width: 4px;" class="black">
                <legend class="yellow accent-4">Editar Categoria</legend>

                <div class="row">
                        <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                            <i class="material-icons yellow-text text-accent-4 prefix">loyalty</i>
                            <input required type="text" id="nome-categoria" name="nome-categoria" maxlength="60" data-length="60" value="{{ $categoria->nome_categoria }}">
                            <label for="nome-categoria">Nome da Categoria</label>
                        </div>
                    </div>
                </fieldset>
                <br>
                <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit" name="action">Atualizar Categoria
                    <i class="material-icons right black-text">send</i>
                </button>
            </form>
        </div>
        @endif

@endsection

@section('rodape')
    @if(isset($categoriasexception))
        @include('erp.partials.msgexception', ['exception' => $categoriasexception])
    @endif

    @if(isset($upcategoriaexception))
        @include('erp.partials.msgexception', ['exception' => $upcategoriaexception])
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
    
    @if(is_null($categoria))
        <script type="text/javascript">
            msgtela('sem cadastro de categorias');
        </script>
    @endif
    
    @if(isset($upcategoria))
        @if(!is_numeric($upcategoria))
        <script type="text/javascript">
            msgtela('Categoria atualizada');
        </script>
        @endif
    @else
        <script type="text/javascript">
            msgtela('Erro na atualização');
        </script>
    @endif

    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
@endsection