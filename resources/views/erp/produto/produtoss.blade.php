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
                    <td>@if(isset($produtos)){{ count($produtos) }}@endif</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('content')
    @if(session('msg'))
        <h1> {{ session('msg') }}</h1>
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
        

        @if(isset($produtos))
        


            <ul class="pagination">
                @foreach($produtos as $produto)
                    <div class="row">
                        <div class="col s4 m4 l4 cyan-text text-accent-4">
                            <i class="material-icons red-text text-lighten-1 prefix">loyalty</i>
                            {{ $produto->descricao }} | {{ $produto->marca }}
                        </div>
                        <div class="col s4 m4 l4 cyan-text text-accent-4">
                            <i class="material-icons purple-text text-lighten-4 prefix">polymer</i>
                            {{ $produto->unidade_medida }}
                        </div>
                        <div class="col s4 m4 l4 cyan-text text-accent-4">
                            <i class="fa fa-archive purple-text prefix" aria-hidden="true"></i>
                            {{ $produto->qtd }}
                        </div>
                    </div>
                @endforeach
                <li @if (1 == $produtos->currentPage()) class="disabled" @else class="waves-effect"@endif><a href="{{ $produtos->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a></li>
                
                @for ($i = 1; $i <= $produtos->lastPage(); $i++)
                    <li @if ($i == $produtos->currentPage()) class="active"@else class="waves-effect"@endif><a href="{{ $produtos->url($i) }}">{{ $i }}</a></li>
                @endfor
                <li @if ($produtos->lastPage() == $produtos->currentPage()) class="disabled" @else class="waves-effect"@endif><a href="{{ $produtos->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a></li>
            </ul>
            
            
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
    @if(isset($produtos))
        <script type="text/javascript">
            //var testemsg = $('#id-teste').val();
            msgtela('sem cadastro de produtos');
        </script>
    @endif
    
    @if(isset($marcas))
        <script type="text/javascript">
            msgtela('sem cadastro de marcas');
        </script>
    @endif
    @if(isset($unmedidas))
        <script type="text/javascript">
            msgtela('sem cadastro de unidades de medidas');
        </script>
    @endif
    @if(isset($categorias))
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
              
            },
            limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
            onAutocomplete: function(slug) {
                // Callback function when value is autcompleted.

                $.ajax({
                    //url: "{{ route('jahx.mostraprodutodescricao', ['' => 'ovo']) }}",
                    url: "/erp/produtos"+slug,
                    type: 'GET',
                    //data: {slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        //window.location.replace("/erp/produtos");
                        return;
                        //debugger;
                        console.log(data);
                    }
                });
            },
            minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
          });
        });
    </script>
@endsection