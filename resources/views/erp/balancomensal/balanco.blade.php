@extends('erp.template.templateerp')

@section('title', 'JahX Balanco mensal')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">BALANCO MENSAL</h3>
        <table class="highlight yellow-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total de Contas a Pagar</td>
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
    <div class="row">
        <div class="input-field col l2 m2 s12">
            <input type="text" name="mes-balanco" id="mes-balanco" value="{{ strftime('%m/%Y') }}">
            <label for="mes-balanco">Mês do Balanço</label>
        </div>
        <div class="col l6 m6 s12">
            <label>Exibir mês selecionado</label>
            <div class="waves-effect waves-light btn yellow accent-4 black-text"
             onclick="exibirRelatorioFechamentoCaixaVendaMes();">
                <i class="material-icons left black-text">flag</i>
                Balanço do mês
            </div>
        </div>
    </div>
    <div class="row black">
        <div class="col l4 amber-text center-align">
            <label class="teal-text" style="font-size: 15px;">TOTAL MARGEM DE CONTRIBUIÇÃO</label><br>
            <span>{{ number_format($total_margem_contribuicao, 2, ',', '.')  }}</span>
        </div>
        <div class="col l4 amber-text center-align">
            <label class="teal-text" style="font-size: 15px;">TOTAL DOS CUSTOS</label><br>
            <span>{{ number_format($total_custos, 2, ',', '.')  }}</span>
        </div>
        <div class="col l4 amber-text center-align">
            <label class="teal-text" style="font-size: 15px;">LUCRO LÍQUIDO</label><br>
            <span>{{ number_format($total_margem_contribuicao - $total_custos, 2, ',', '.')  }}</span>
        </div>
    </div>
    
    <div class="divider teal"></div>
    <h5 class="center-align">Cálculo da margem de contribuição mensal</h5>
    <table class="bordered highlight">
        <thead>
            <tr>
                <th>Ordem</th>
                <th>Produto</th>
                <th>Preço vendido</th>
                <th>Preço comprado</th>
                <th>Margem de lucro</th>
                <th>QTD vendida</th>
                <th>Margem de contribuição</th>
            </tr>
        </thead>

        <tbody>
            @foreach($preco_de_venda as $pv)
            <tr class="cyan-text">
                <td class="black-text">{{ $loop->index + 1 }}</td>
                <td>{{ $pv->descricao }}</td>
                <td class="teal-text">{{ number_format($pv->preco_venda, 2, ',', '.') }}</td>
                <td class="teal-text">{{ number_format($pv->preco_compra, 2, ',', '.') }}</td>
                <td class="purple-text">{{ number_format($pv->margem_lucro, 2, ',', '.') }}</td>
                <td>{{ $pv->qtd_vendida }}</td>
                <td class="purple-text">{{ number_format($pv->margem_contribuicao, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="divider teal"></div>
    <h4 class="center-align">Produtos vendidos com preços diferentes</h4>
    <table class="bordered highlight">
        <thead>
            <tr>
                <th>Ordem</th>
                <th>Produto</th>
                <th>Preço vendido</th>
                <th>Preço comprado</th>
                <th>Margem de lucro</th>
                <th>QTD vendida</th>
                <th>Margem de contribuição</th>
            </tr>
        </thead>

        <tbody>
            @foreach($produtos_vendidos_precos_diferentes as $pdif)
            <tr class="cyan-text text-accent-4">
                <td class="black-text">{{ $loop->index + 1 }}</td>
                <td>{{ $pdif->descricao }}</td>
                <td class="teal-text">{{ number_format($pdif->preco_vendido, 2, ',', '.') }}</td>
                <td class="teal-text">{{ number_format($pdif->preco_compra, 2, ',', '.') }}</td>
                <td class="purple-text">{{ number_format($pdif->margem_lucro, 2, ',', '.') }}</td>
                <td>{{ $pdif->qtd_venda }}</td>
                <td class="purple-text">{{ number_format($pdif->margem_contribuicao, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection

@section('script')
    <script src="{{ asset('js/jquery.maskedinput.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#mes-balanco').mask('99-9999');
        });

        function exibirRelatorioFechamentoCaixaVendaMes(){
            var mes_do_balanco = $('#mes-balanco').val();
            window.location.replace("/erp/balanco-mensal/"+mes_do_balanco);
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