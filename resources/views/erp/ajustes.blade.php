@extends('erp.template.templateerp')

@section('title', 'Ajustes')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h1 class="center-align white-text">Ajustes</h1>
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

    <div class="collection">
        <a href="{{ route('jahx.usuarios') }}" class="collection-item purple-text text-darken-3">
            <i class="material-icons blue-text text-lighten-1 prefix">face</i>
            Usuários
        </a>
        <a href="{{ route('jahx.categorias') }}" class="collection-item purple-text text-darken-3">
            <i class="material-icons prefix">bookmark_border</i>
            Categoria de Produtos
        </a>
        <a href="{{ route('jahx.unmedidas') }}" class="collection-item purple-text text-darken-3">
            <i class="material-icons purple-text text-lighten-4 prefix">polymer</i>
            Unidades de Medidas
        </a>
        <a href="{{ route('jahx.marcas') }}" class="collection-item purple-text text-darken-3">
            <i class="material-icons red-text text-lighten-1 prefix">loyalty</i>
            Marcas
        </a>
        <a href="{{ route('jahx.formapagamentos') }}" class="collection-item purple-text text-darken-3">
            <i class="material-icons green-text text-lighten-1 prefix">credit_card</i>
            Forma de Pagamentos
        </a>
        <a href="{{ route('jahx.custos') }}" class="collection-item purple-text text-darken-3">
            <i class="material-icons red-text text-lighten-1 prefix">sentiment_dissatisfied</i>
            Custos
        </a>
    </div>
            

    

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
@endsection