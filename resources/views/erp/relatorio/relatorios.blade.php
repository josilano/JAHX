@extends('erp.template.templateerp')

@section('title', 'Relatorios')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">RELATÓRIOS</h3>
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
    <h4>RELATÓRIOS PARA O ERP</h4>
    <div class="row">
        <div class="input-field col l2 m2 s12">
            <input type="text" class="datepicker" name="data-venda" id="data-venda" name="data-venda" value="{{ strftime('%d/%m/%Y') }}">
            <label for="data-venda">Data das Vendas</label>
        </div>
    </div>
    <div class="row">
        <div class="col l6 m6 s12">
            <label>Fechamento do caixa ERP(DAV)</label>
            <div class="waves-effect waves-light btn yellow accent-4 black-text" 
                onclick="exibirRelatorioFechamentoCaixaDAV();" href="#{ route('jahx.exibirvendadiacupomdav') }}">
                <i class="material-icons left black-text">flag</i>
                Faturamento do dia DAV
            </div>
        </div>
        <div class="col l6 m6 s12">
            <label>Fechamento do caixa ERP(Venda)</label>
            <div class="waves-effect waves-light btn yellow accent-4 black-text"
             onclick="exibirRelatorioFechamentoCaixaVenda();">
                <i class="material-icons left black-text">flag</i>
                Faturamento do dia Venda
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <div class="input-field col l2 m2 s12">
            <input type="text" name="mes-venda" id="mes-venda" name="mes-venda" value="{{ strftime('%m/%Y') }}">
            <label for="mes-venda">Mês das Vendas</label>
        </div>
    </div>
    <div class="row">
        <div class="col l6 m6 s12">
            <label>Fechamento do caixa ERP(Venda)</label>
            <div class="waves-effect waves-light btn yellow accent-4 black-text"
             onclick="exibirRelatorioFechamentoCaixaVendaMes();">
                <i class="material-icons left black-text">flag</i>
                Faturamento do mês - Venda
            </div>
        </div>
    </div>

@endsection

@section('rodape')
    
@endsection

@section('script')
<script src="{{ asset('js/jquery.maskedinput.min.js') }}" type="text/javascript"></script>
    @if(session('msg'))
    <script type="text/javascript">
        $(document).ready(function(){
            $('#modal1').modal('open');
        });
    </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function(){
            $('#mes-venda').mask('99-9999');
        });
        function exibirRelatorioFechamentoCaixaDAV(){
            var data_da_venda = $('#data-venda').val().replace('/', '-').replace('/', '-');
            window.location.replace("/erp/pdf/dav/exibir/venda-do-dia/cupom/"+data_da_venda);
        }

        function exibirRelatorioFechamentoCaixaVenda(){
            var data_da_venda = $('#data-venda').val().replace('/', '-').replace('/', '-');
            window.location.replace("/erp/pdf/venda/exibir/venda-do-dia/cupom/"+data_da_venda);
        }

        function exibirRelatorioFechamentoCaixaVendaMes(){
            var mes_da_venda = $('#mes-venda').val();
            window.location.replace("/erp/pdf/venda/exibir/venda-do-mes/cupom/"+mes_da_venda);
        }
    </script>
@endsection