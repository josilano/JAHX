@extends('erp.template.templateerp')

@section('title', 'JahX Vendas')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">VENDA</h3>
    </div>
@endsection

@section('content')
    @if (session('msg'))
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
        <a href="{{ route('jahx.vendas') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons waves-effect blue-text">shopping_cart</i>
            VENDAS
        </a>
    </div>
    <br><br>
    @if (isset($venda))
        @include ('erp.partials.vendas.componentemostraumavenda', ['venda' => $venda])
        
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
                @foreach($itensVenda as $item)
                <tr class="cyan-text text-accent-4">
                    <td>{{ $item->ean_produto }}</td>
                    <td>{{ $item->descricao_produto }}</td>
                    <td>{{ $item->qtd_venda }}</td>
                    <td>{{ $item->un_produto }}</td>
                    <td>{{ number_format($item->preco_vendido, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="divider"></div>
        @include ('erp.partials.clientes.componentemostraumcliente')
        
        @if ($venda->status != 'cancelada')
            <a class="waves-effect waves-light btn-large red col l4 m4 s12" href="#modal1"><i class="material-icons left">delete</i>CANCELAR</a>
            <a class="waves-effect waves-light btn-large grey col l4 m4 s12" href="{{ route('jahx.baixarrecibo', ['id' => $venda->id]) }}"><i class="material-icons left red-text">cloud_download</i>BAIXAR PDF</a>
            <a class="waves-effect waves-light btn-large blue col l4 m4 s12" href="{{ route('jahx.exibirrecibo', ['id' => $venda->id]) }}"><i class="material-icons left red-text">picture_as_pdf</i>EXIBIR PDF</a>
        @endif

        <div id="modal1" class="modal">
            <div class="modal-content">
              <h4>Confirmação de Cancelamento</h4>
              <p>Realmente deseja cancelar?</p>
              <form id="cancela-form" action="{{ route('jahx.cancelavenda', ['id' => $venda->id]) }}" method="POST">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="input-field col l12 m12 s12">
                            <i class="material-icons yellow-text text-accent-4 prefix">description</i>
                            <input type="text" name="observacoes-cancelamento" id="observacoes-cancelamento" maxlength="75" data-length="75">
                            <label for="observacoes-cancelamento">Motivo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <a href="#!" onclick="$('#modal1').modal('close');">Não cancelar</a>

              <a href="{{ route('jahx.cancelavenda', ['id' => $venda->id]) }}" class="modal-action modal-close waves-effect waves-green btn-flat"
                    onclick="event.preventDefault();
                             document.getElementById('cancela-form').submit();">
                    <i class="material-icons">check</i>OK
                </a>
            </div>
        </div>
    @endif
@endsection

@section('rodape')
    @if(isset($upvendaexception))
        @include('erp.partials.msgexception', ['exception' => $upvendaexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    @if(is_null($venda))
        <script type="text/javascript">
            msgtela('venda inexistente');
        </script>
    @endif
    
    @if(isset($upvenda))
        @if(!is_numeric($upvenda))
        <script type="text/javascript">
            msgtela('Venda atualizada');
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