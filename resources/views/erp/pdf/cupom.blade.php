<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>    
    <title>cupom não fiscal</title>
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
        <span><strong>CASTELO DO QUEIJO</strong><br>RUA JOAQUIM LEITAO, 1044, ANTONIO BEZERRA<br>FORTALEZA/CE - 60360-840<br><strong>(85) 99762-3235(WhatsApp)</strong></span>
    </div>
    <span>------------------------------------------------------------------------------------</span><br>
    <div style="float: left; padding-top: -3px; padding-bottom: -3px;">{{ strftime('%d/%m/%Y %H:%M:%S', strtotime($venda->updated_at)) }}</div><div style="text-align: right; clear: right; padding-right: 4px; padding-top: -3px; padding-bottom: -3px;"><strong>Nº {{ $venda->id }}</strong></div>
    <span>------------------------------------------------------------------------------------</span>
    <div style="text-align: center;"><strong>{{ strtoupper($nomerecibo) }}</strong></div>
    <span>------------------------------------------------------------------------------------</span>
    <br>
    <table style="font-size: 9px;">
        <thead>
            <tr>
                <td>ITEM</td>
                <td>CÓDIGO</td>
                <td>DESCRICAO</td>
                <td>QTD</td>
                <td>UN</td>
                <td>VL.UN</td>
                <td>VL.ITEM</td>
            </tr>
        </thead>

        <tbody>
            @foreach($itens as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item->ean_produto }}</td>
                <td>{{ $item->descricao_produto }}</td>
                <td>{{ $item->qtd_venda }}</td>
                <td>{{ $item->un_produto }}</td>
                <td>{{ number_format($item->preco_vendido, 2, ',', '.') }}</td>
                <td>{{ number_format($item->subtotal, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table><br>
    <span>------------------------------------------------------------------------------------</span><br>
    <div>
        <div style="float: left;"><strong>SUBTOTAL</strong></div><div style="text-align: right; clear: right; padding-right: 4px;"><strong>R$ {{ number_format($venda->total_itens, 2, ',', '.') }}</strong></div>
        @if($venda->forma_pg_venda === 'CARTÃO DE CRÉDITO' || $venda->forma_pg_venda === 'CARTÃO DE DÉBITO')
        <div style="float: left;">DESCONTO/ACRESCIMO</div><div style="text-align: right; clear: right; padding-right: 4px;">R$ @if($venda->tipo_desconto === 'porcento'){{ str_replace('-', '+', number_format($venda->total_itens*str_replace(',', '.', $venda->desconto)/100, 2, ',', '.')) }}@else{{ str_replace('-', '+', number_format(str_replace(',', '.', $venda->desconto), 2, ',', '.')) }}@endif</div>
        <div style="float: left;"><strong>TOTAL</strong></div><div style="text-align: right; clear: right; padding-right: 4px;"><strong>R$ {{ number_format($venda->total_venda, 2, ',', '.') }}</strong></div>
        <div style="float: left;">CARTAO</div><div style="text-align: right; clear: right; padding-right: 4px;"> R$ {{ number_format($venda->dinheiro, 2, ',', '.') }}</div>
        @elseif($venda->forma_pg_venda === 'DINHEIRO')
        <div style="float: left;">DESCONTO/ACRESCIMO</div><div style="text-align: right; clear: right; padding-right: 4px;">R$ @if($venda->tipo_desconto === 'porcento'){{ str_replace('-', '+', number_format($venda->total_itens*str_replace(',', '.', $venda->desconto)/100, 2, ',', '.')) }}@else{{ str_replace('-', '+', number_format(str_replace(',', '.', $venda->desconto), 2, ',', '.')) }}@endif</div>
        <div style="float: left;"><strong>TOTAL</strong></div><div style="text-align: right; clear: right; padding-right: 4px;"><strong>R$ {{ number_format($venda->total_venda, 2, ',', '.') }}</strong></div>
        <div style="float: left;">DINHEIRO</div><div style="text-align: right; clear: right; padding-right: 4px;"> R$ {{ number_format($venda->dinheiro, 2, ',', '.') }}</div>
        <div style="float: left;">TROCO</div><div style="text-align: right; clear: right; padding-right: 4px;">R$ {{ number_format($venda->troco, 2, ',', '.') }}</div>
        @elseif($venda->forma_pg_venda === 'PIX')
        <div style="float: left;">DESCONTO/ACRESCIMO</div><div style="text-align: right; clear: right; padding-right: 4px;">R$ @if($venda->tipo_desconto === 'porcento'){{ str_replace('-', '+', number_format($venda->total_itens*str_replace(',', '.', $venda->desconto)/100, 2, ',', '.')) }}@else{{ str_replace('-', '+', number_format(str_replace(',', '.', $venda->desconto), 2, ',', '.')) }}@endif</div>
        <div style="float: left;"><strong>TOTAL</strong></div><div style="text-align: right; clear: right; padding-right: 4px;"><strong>R$ {{ number_format($venda->total_venda, 2, ',', '.') }}</strong></div>
        <div style="float: left;">TRANSF. BANCARIA</div><div style="text-align: right; clear: right; padding-right: 4px;"> R$ {{ number_format($venda->dinheiro, 2, ',', '.') }}</div>
        @else
        <div style="float: left;">DESCONTO/ACRESCIMO</div><div style="text-align: right; clear: right; padding-right: 4px;">R$ @if($venda->tipo_desconto === 'porcento'){{ str_replace('-', '+', number_format($suprimentoEmCartao[0]->valor*str_replace(',', '.', $venda->desconto)/100, 2, ',', '.')) }}@else{{ str_replace('-', '+', number_format(str_replace(',', '.', $venda->desconto), 2, ',', '.')) }}@endif</div>
        <div style="float: left;"><strong>TOTAL</strong></div><div style="text-align: right; clear: right; padding-right: 4px;"><strong>R$ {{ number_format($venda->total_venda, 2, ',', '.') }}</strong></div>
        <div style="float: left;">DINHEIRO</div><div style="text-align: right; clear: right; padding-right: 4px;"> R$ {{ number_format($venda->dinheiro, 2, ',', '.') }}</div>
        <div style="float: left;">CARTAO</div><div style="text-align: right; clear: right; padding-right: 4px;"> R$ {{ number_format($suprimentoEmCartao[0]->valor, 2, ',', '.') }}</div>
        <div style="float: left;">TROCO</div><div style="text-align: right; clear: right; padding-right: 4px;">R$ {{ number_format($venda->troco, 2, ',', '.') }}</div>
        @endif
    </div>
    <span>------------------------------------------------------------------------------------</span>
    <span style="font-size: 10px; font-family: arial;">SEM VALOR FISCAL</span>
    <div><strong>CLIENTE: {{ $cliente->nome_rsocial }}</strong></div>
    @if($cliente->id != 1)
    <table>
        <tr>
            <td colspan="2">
                <label>CPF/CNPJ</label><br>
                <strong>{{ $cliente->cpf_cnpj }}</strong>
            </td>
            <td colspan="2">
                <label>NOME FANTASIA</label><br>
                <strong>{{ $cliente->nome_fantasia }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <label>ENDEREÇO</label><br>
                <strong>{{ $cliente->logradouro }}, {{ $cliente->numero }}, {{ $cliente->complemento }}, {{ $cliente->bairro }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>CIDADE</label><br>
                <strong>{{ $cliente->cidade }}/ {{ $cliente->estado }}</strong>
            </td>
            <td colspan="2">
                <label>CEP</label><br>
                <strong>{{ $cliente->cep }}</strong>
            </td>
        </tr>
        <tr>
            <td>
                <label>TELEFONE 1</label><br>
                <strong>{{ $cliente->tel_principal }}</strong>
            </td>
            <td>
                <label>TELEFONE 2</label><br>
                <strong>{{ $cliente->tel_secundario }}</strong>
            </td>
            <td colspan="2">
                <label>E-MAIL</label><br>
                <strong>{{ $cliente->email }}</strong>
            </td>
        </tr>
    </table>
    @endif
    <span>------------------------------------------------------------------------------------</span>
    <div style="">DETALHES</div>
    <table style="font-family: arial;">
        <tbody>
            <tr>
                <td>
                    <label class="txtcinza">STATUS</label><br>
                    <strong>{{ $venda->status }}</strong>
                </td>
                <td>
                    <label class="txtcinza">FORMA DE PAGAMENTO</label><br>
                    <strong>{{ $venda->forma_pg_venda }}</strong>
                </td>
                <td>
                    <label class="txtcinza">PARCELAS</label><br>
                    <strong>{{ $venda->parcelas }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <label class="">OBSERVACOES</label><br>
                    <span>{{ $venda->observacoes }}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <span>------------------------------------------------------------------------------------</span>
    <div style="text-align: center;">NOSSA SATISFACAO E VENDER BARATO!</div>
</div>
</body>
</html>