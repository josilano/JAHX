@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">CLIENTES</h3>
        <table class="highlight yellow-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Clientes Cadastrados</td>
                    <td>@if(isset($clientes)){{ $clientes->total() }}@endif</td>
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

    @include ('erp.partials.clientes.componentecadastracliente')

    <a class="btn-large purple" href="{{ route('jahx.telclientes') }}">Lista de Telefones</a>

    @if (isset($clientes))
        @include ('erp.partials.clientes.componentelistacliente', ['clientes' => $clientes])

        @include ('erp.partials.componentepaginacao', ['paginacao' => $clientes])
    @endif
    
@endsection

@section('rodape')
    @if(isset($clientesexception))
        @include('erp.partials.msgexception', ['exception' => $clientesexception])
    @endif

    @if(isset($cadclienteexception))
        @include('erp.partials.msgexception', ['exception' => $cadclienteexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    @if(is_null($clientes))
        <script type="text/javascript">
            msgtela('sem cadastro de clientes');
        </script>
    @endif
    
    @if(isset($cadcliente))
        @if(!is_numeric($cadcliente))
        <script type="text/javascript">
            msgtela('Cliente cadastrado');
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
              @foreach($clientesall as $cliente)
              "{{ $cliente->nome_rsocial }}": null,
              "{{ $cliente->nome_fantasia }}": null,
              @endforeach
            },
            limit: 20,
            onAutocomplete: function(slug) {
                $.ajax({
                    url: "/erp/clientes/q="+slug,
                    type: 'GET',
                    //data: {slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        window.location.replace("/erp/clientes/q="+slug);
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