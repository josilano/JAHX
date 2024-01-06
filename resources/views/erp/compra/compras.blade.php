@extends('erp.template.templateerp')

@section('title', 'JahX Compras')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">COMPRAS</h3>
        <table class="highlight yellow-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Compras Realizadas</td>
                    <td>@if(isset($compras)){{ $compras->total() }}@endif</td>
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

    @include ('erp.partials.componenteautocomplete')

    <a class="waves-effect waves-light btn yellow accent-4 black-text" href="{{ route('jahx.criarcompra') }}"><i class="material-icons left black-text">flag</i>Iniciar compra</a>

    @if (isset($compras))
        @include ('erp.partials.compras.componentelistacompras', ['compras' => $compras])

        @include ('erp.partials.componentepaginacao', ['paginacao' => $compras])
    @endif
    
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
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    @if(is_null($compras))
        <script type="text/javascript">
            msgtela('sem cadastro de compras');
        </script>
    @endif
    
    @if(isset($cadcompra))
        @if(!is_numeric($cadcompra))
        <script type="text/javascript">
            msgtela('Compra cadastrada');
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
              @foreach($listacompras as $compra)
              "{{ sprintf('%03d', $compra->id) }}": null,
              @endforeach
            },
            limit: 20,
            onAutocomplete: function(slug) {
                $.ajax({
                    url: "/erp/compras/"+slug,
                    type: 'GET',
                    //data: {slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        window.location.replace("/erp/compras/"+slug);
                        debugger;
                        console.log(slug);
                    }
                });
            },
            minLength: 1,
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