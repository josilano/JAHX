@extends('erp.template.templateerp')

@section('title', 'JahX Pré-Vendas')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">PRÉ-VENDA</h3>
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
        <a href="{{ route('jahx.davs') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons lime-text text-accent-2 waves-effect">receipt</i>
            PRÉ-VENDAS
        </a>
    </div>
    <br><br>
    @if (isset($dav))
        @include ('erp.partials.davs.componentemostraumadav', ['venda' => $dav])
        
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
                @foreach($itensPreVenda as $item)
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
        
        <a class="waves-effect waves-light btn-large red col l3 m3 s12" href="#modal1"><i class="material-icons left">delete</i>APAGAR</a>

        <a href="{{ route('jahx.vendedav', ['id' => $dav->id]) }}" class="waves-effect waves-light btn-large yellow accent-4 col l3 m3 s12" onclick="event.preventDefault();document.getElementById('vende-dav-form').submit();">
            <i class="material-icons left blue-text">shopping_cart</i>VENDER
        </a>
        <a class="waves-effect waves-light btn-large grey col l3 m3 s12" href="{{ route('jahx.baixarrecibodav', ['id' => $dav->id]) }}"><i class="material-icons left red-text">cloud_download</i>BAIXAR PDF</a>
        <a class="waves-effect waves-light btn-large blue col l3 m3 s12" href="{{ route('jahx.exibirrecibodav', ['id' => $dav->id]) }}"><i class="material-icons left red-text">picture_as_pdf</i>EXIBIR PDF</a>
        
        <div id="modal1" class="modal">
            <div class="modal-content">
              <h4>Confirmação de Exclusão</h4>
              <p>Realmente deseja excluir?</p>
            </div>
            <div class="modal-footer">
                <a href="#!" onclick="$('#modal1').modal('close');">Não apagar</a>

                <a href="{{ route('jahx.deletadav', ['id' => $dav->id]) }}" class="modal-action modal-close waves-effect waves-green btn-flat"
                    onclick="event.preventDefault();
                             document.getElementById('cancela-form').submit();">
                    <i class="material-icons">check</i>OK
                </a>

                <form id="cancela-form" action="{{ route('jahx.deletadav', ['id' => $dav->id]) }}" method="POST" style="display: none;">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                </form>
            </div>
        </div>

        <form id="vende-dav-form" action="{{ route('jahx.vendedav', ['id' => $dav->id]) }}" method="POST" style="display: none;">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
        </form>
    @endif
@endsection

@section('rodape')
    @if(isset($updavexception))
        @include('erp.partials.msgexception', ['exception' => $updavexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    @if(is_null($dav))
        <script type="text/javascript">
            msgtela('pré-venda inexistente');
        </script>
    @endif
    
    @if(isset($updav))
        @if(!is_numeric($updav))
        <script type="text/javascript">
            msgtela('Pré-Venda atualizada');
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