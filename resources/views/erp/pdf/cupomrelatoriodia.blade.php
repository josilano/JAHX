<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>    
    <title>cupom de relatorio do dia</title>
    <style type="text/css">
        body {
            margin: 0 auto;
            margin-right: 5px;
            margin-left: -36px;
            width: 72mm;
            font-family: "Letter Gothic";
            font-size: 10px;
            padding-top: -25px;
        }
        .txtnegrito {
            font-style: inherit;
        }
    </style>
</head>
<body>
<div>
    <div style="text-align: center;">
        <span><strong>CASTELO DO QUEIJO</strong></span>
    </div>
    <span>------------------------------------------------------------------------------------</span><br>
    <div style="float: left; padding-top: -3px; padding-bottom: -3px;">{{ strftime('%d/%m/%Y %H:%M:%S') }}</div><div style="text-align: right; clear: right; padding-right: 4px; padding-top: -3px; padding-bottom: -3px;"><strong>Nº </strong></div>
    <span>------------------------------------------------------------------------------------</span>
    <div style="text-align: center;"><strong>{{ strtoupper($nomerecibo) }}</strong></div>
    <span>------------------------------------------------------------------------------------</span>
    <br>
    <table>
        <thead>
            <tr>
                <td>ITEM</td>
                <td>DESCRICAO</td>
                <td>QTD TOTAL VENDIDA</td>
            </tr>
        </thead>

        <tbody>
            @foreach($totalvendasitens as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item->descricao_produto }}</td>
                <td style="text-align: center;">{{ $item->total_vendido }}</td>
            </tr>
            @endforeach
        </tbody>
    </table><br>
    <span>------------------------------------------------------------------------------------</span><br>
    <div><strong>DATA DO FATURAMENTO: {{ $data_da_venda }}</strong></div>
    <div><strong>FATURAMENTO: R$ {{ number_format($totalvendas, 2, ',', '.') }}</strong></div>
    @foreach($totaldevendas as $venda)
        <div><strong>QTD VENDAS {{ $venda->forma_pg_venda }}: {{ $venda->qtd_venda }}</strong></div>
        <div><strong>TOTAL VENDAS {{ $venda->forma_pg_venda }}: R$ {{ number_format($venda->total_venda, 2, ',', '.') }}</strong></div>
    @endforeach
    <span>------------------------------------------------------------------------------------</span>
    <span>SUPRIMENTOS</span>
    <table>
        <thead>
            <tr>
                <td>ORDEM</td>
                <td>DESCRICAO</td>
                <td>VALOR</td>
            </tr>
        </thead>

        <tbody>
            @foreach($suprimentos as $s)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $s->descricao }}</td>
                <td style="text-align: center;">{{ number_format($s->valor, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <span>------------------------------------------------------------------------------------</span>
    <span>SANGRIAS</span>
    <table>
        <thead>
            <tr>
                <td>ORDEM</td>
                <td>DESCRICAO</td>
                <td>VALOR</td>
            </tr>
        </thead>

        <tbody>
            @foreach($sangrias as $s)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $s->descricao }}</td>
                <td style="text-align: center;">{{ number_format($s->valor, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <span>------------------------------------------------------------------------------------</span>
    <div><strong>TOTAL DE SUPRIMENTOS: R$ {{ number_format($totalsuprimento, 2, ',', '.') }}</strong></div>
    <div><strong>TOTAL DE SANGRIAS: R$ {{ number_format($totalsangria, 2, ',', '.') }}</strong></div>
    <div><strong>SALDO DO REGISTRO DO CAIXA: R$ {{ number_format($totalsuprimento-$totalsangria, 2, ',', '.') }}</strong></div>
    <div><strong>TOTAL DE CONTAS A RECEBER: R$ {{ number_format($totalareceber, 2, ',', '.') }}</strong></div>
    <div><strong>FECHAMENTO DO CAIXA: R$ {{ number_format($totalvendasdinheiro+$totalsuprimento-$totalsangria-$totalareceber, 2, ',', '.') }}</strong></div>
    <span>------------------------------------------------------------------------------------</span>
    <div style="text-align: center;">FATURAMENTO SIMPLES DO CAIXA</div>
    <span>------------------------------------------------------------------------------------</span>
    <div>OBS1.: SALDO DO REGISTRO DO CAIXA = SUPRIMENTOS - SANGRIAS</div>
    <div>OBS2.: FECHAMENTO DO CAIXA = TOTAL VENDAS A DINHEIRO + SALDO DO REGISTRO DO CAIXA - TOTAL DE CONTAS A RECEBER</div>
</div>
</body>
</html>