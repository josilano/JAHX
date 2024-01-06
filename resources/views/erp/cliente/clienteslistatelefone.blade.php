@extends('erp.template.templateerp')

@section('title', 'JahX - telefones')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="amber-text text-accent-4 center-align">LISTA CONTATOS CLIENTES</h3>
        <table class="highlight amber-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Clientes Cadastrados</td>
                    <td>@if(isset($clientes)){{ $clientes->count() }}@endif</td>
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

    <div class="col l3 m3 s4 yellow-text text-accent-4">
        <a href="{{ route('jahx.clientes') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons light-green-text text-accent-3 waves-effect">supervisor_account</i>
            CLIENTES
        </a>
    </div>
    <br><br>
    @if (isset($clientes))
        @include ('erp.partials.clientes.componentelistatelefone', ['clientes' => $clientes])
    @endif
    
@endsection

@section('rodape')
    
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

    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
@endsection