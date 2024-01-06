@extends('erp.template.templateerp')

@section('title', 'JahX Vendas')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">VENDAS</h3>
        <table class="highlight yellow-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Vendas Realizadas</td>
                    <td>@if(isset($vendas)){{ $vendas->total() }}@endif</td>
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

    <div class="row">
        <div class="col l6 m6 s12">
            <a class="waves-effect waves-light btn yellow accent-4 black-text" href="{{ route('jahx.criarvenda') }}"><i class="material-icons left black-text">flag</i>Iniciar venda</a>
        </div>
        <div class="input-field col l2 m2 s12">
            <input type="text" class="datepicker" name="data-venda" id="data-venda" onchange="permiteDataEnvio();">
            <label for="data-venda">Data das Vendas</label>
        </div>
        <div class="col l4 m4 s12">
            <div class="waves-effect waves-light btn yellow accent-4 black-text right"
                    onclick="buscaDavPorData();" id="link-busca-data-venda" disabled>
                <i class="material-icons left black-text">calendar_today</i>Buscar por data
            </div>
        </div>
    </div>

    @if (isset($vendas))
        @include ('erp.partials.vendas.componentelistavendas', ['vendas' => $vendas])

        @include ('erp.partials.componentepaginacao', ['paginacao' => $vendas])
    @endif
    
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
    @if(is_null($vendas))
        <script type="text/javascript">
            msgtela('sem cadastro de vendas');
        </script>
    @endif
    
    @if(isset($cadvenda))
        @if(!is_numeric($cadvenda))
        <script type="text/javascript">
            msgtela('Venda cadastrada');
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
              @foreach($listavendas as $venda)
              "{{ sprintf('%03d', $venda->id) }}": null,
              @endforeach
            },
            limit: 20,
            onAutocomplete: function(slug) {
                $.ajax({
                    url: "/erp/vendas/"+slug,
                    type: 'GET',
                    //data: {slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        window.location.replace("/erp/vendas/"+slug);
                        debugger;
                        console.log(slug);
                    }
                });
            },
            minLength: 1,
          });
        });

        function permiteDataEnvio(){
            if ($('#data-venda').val() != '')
                $('#link-busca-data-venda').attr('disabled', false);
            else 
                $('#link-busca-data-venda').attr('disabled', true);
        }

        function buscaDavPorData(){
            var dia = $('#data-venda').val().replace('/', '-').replace('/', '-');
            window.location.replace("/erp/vendas/periodo/venda/"+dia);
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