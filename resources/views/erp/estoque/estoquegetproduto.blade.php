@extends('erp.template.templateerp')

@section('title', 'JahX - Estoque')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">ESTOQUE</h3>
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
              <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
            </div>
        </div>
    @endif
    <div class="col l3 m3 s4">
        <a href="{{ route('jahx.estoque') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons waves-effect blue-text">assignment</i>
            ESTOQUE
        </a>
    </div>
    <br><br>
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

    @if(isset($produto))
    
    <table class="striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>UN</th>
                <th>QTD mínima</th>
                <th>QTD</th>
            </tr>
        </thead>

        <tbody>
            <tr class="cyan-text text-accent-4">
                <td>{{ $produto->ean }}</td>
                <td>{{ $produto->descricao }}</td>
                <td>{{ $produto->unidade_medida }}</td>
                <td>{{ $produto->qtd_minima }}</td>
                <td>{{ $produto->qtd }} @if ($produto->qtd < $produto->qtd_minima)<span class="new badge red" data-badge-caption="em falta">{{ $produto->qtd_minima - $produto->qtd }}</span>@endif</td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col l12 m12 s12 center-align yellow lighten-5">
            <i class="material-icons red-text">mode_edit</i>
            <a class="linkeditarcliente" href="{{ route('jahx.mostraproduto', ['id' => $produto->id]) }}" >Editar</a>
        </div>
    </div>
    @endif
    
@endsection

@section('rodape')
    
@endsection

@section('script')
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
                window.location.replace("/erp/estoque/descricao/"+slug);
            },
            minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
          });
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