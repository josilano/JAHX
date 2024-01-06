@extends('erp.template.templateerp')

@section('title', 'JahX Compras')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">COMPRA</h3>
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
    <div class="col l3 m3 s4">
        <a href="{{ route('jahx.compras') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons waves-effect blue-text">add_shopping_cart</i>
            COMPRAS
        </a>
    </div>
    <br><br>
    @if (isset($compra))
        @include ('erp.partials.compras.componentemostraumacompra', ['compra' => $compra])
        
        <table class="yellow lighten-4">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>QTD</th>
                    <th>UN</th>
                    <th>Valor Un.</th>
                    <th>Valor Item</th>
                </tr>
            </thead>

            <tbody>
                @foreach($itensCompra as $item)
                <?php $produto = ProdutoFacade::find($item->id_produto); ?>
                <tr class="cyan-text text-accent-4">
                    <td>{{ $produto->ean }}</td>
                    <td>{{ $produto->descricao }}</td>
                    <td>{{ $item->qtd_compra }}</td>
                    <td>{{ $produto->unidade_medida }}</td>
                    <td>{{ number_format($item->preco_compra, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->preco_compra * $item->qtd_compra, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="divider"></div>
        @include ('erp.partials.clientes.componentemostraumcliente', ['fornecedor' => 'fornecedor'])
        
        @if ($compra->status != 'cancelada')
            <a class="waves-effect waves-light btn-large red col l12 m12 s12" href="#modal1"><i class="material-icons left">delete</i>CANCELAR</a>
        @endif

        <div id="modal1" class="modal">
            <div class="modal-content">
              <h4>Confirmação de Cancelamento</h4>
              <p>Realmente deseja cancelar?</p>
            </div>
            <div class="modal-footer">
              <a href="#!" onclick="$('#modal1').modal('close');">Não cancelar</a>

              <a href="{{ route('jahx.cancelacompra', ['id' => $compra->id]) }}" class="modal-action modal-close waves-effect waves-green btn-flat"
                    onclick="event.preventDefault();
                             document.getElementById('cancela-form').submit();">
                    <i class="material-icons">check</i>OK
                </a>

                <form id="cancela-form" action="{{ route('jahx.cancelacompra', ['id' => $compra->id]) }}" method="POST" style="display: none;">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    @endif
@endsection

@section('rodape')
    @if(isset($upcompraexception))
        @include('erp.partials.msgexception', ['exception' => $upcompraexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    @if(is_null($compra))
        <script type="text/javascript">
            msgtela('compra inexistente');
        </script>
    @endif
    
    @if(isset($upcompra))
        @if(!is_numeric($upcompra))
        <script type="text/javascript">
            msgtela('Compra atualizada');
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