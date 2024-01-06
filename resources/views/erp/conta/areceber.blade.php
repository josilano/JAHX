@extends('erp.template.templateerp')

@section('title', 'JahX Conta a Receber')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">CONTAS A RECEBER</h3>
        <table class="highlight yellow-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total de Contas a Receber</td>
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

    @if (isset($vendas_agrupadas))
    <ul class="collapsible" data-collapsible="accordion">
    @foreach($vendas_agrupadas as $vagp)
    <li>
        <div class="collapsible-header">
            <div class=""><?php $cli = ClienteFacade::find($vagp->id_cliente); ?>
                <span class="cyan-text">{{ $cli->nome_rsocial }}-{{ $cli->nome_fantasia }}</span>
                <span class="teal-text">Quantidade: {{ $vagp->qtd_restante }}</span>
                <span class="purple-text">Total: {{ number_format($vagp->total_restante, 2, ',', '.') }}</span>
            </div>
        </div>
        <div class="collapsible-body purple lighten-5">
            <table class="striped">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Usuário</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Restante</th>
                        <th>Editar</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($vendas_sem_paginate as $venda)
                @if ($venda->id_cliente == $vagp->id_cliente)
                    <tr class="cyan-text text-accent-4">
                        <td>{{ $venda->id }}</td>
                        <td>{{ $venda->users->name }}</td>
                        <td>{{ $venda->cliente->nome_rsocial .'-'. $venda->cliente->nome_fantasia }}</td>
                        <td class="teal-text">{{ strftime('%d/%m/%Y', strtotime($venda->created_at)) }}</td>
                        <td class="purple-text">{{ number_format($venda->restante, 2, ',', '.') }}</td>
                        <td><a href="{{ route('jahx.editavenda', ['id' => $venda->id]) }}"><i class="material-icons red-text">mode_edit</i></a></td>
                    </tr>
                @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </li>
    @endforeach
    </ul>
    @endif
    
    <div class="divider amber"></div>
    <div class="row">
        <div class="col l12 m6 s12 purple-text right-align">
            <i class="material-icons amber-text">attach_money</i>
            <span class="blue-text">Total de saldo restante a receber</span> R$ {{ number_format($totalareceber, 2, ',', '.') }}
        </div>
    </div>
    <div class="divider amber"></div>
    <h5 class="teal-text center-align">Listagem de todas as vendas a receber</h5>
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
    
    <script type="text/javascript">
        $(document).ready(function() {
            
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