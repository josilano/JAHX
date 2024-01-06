<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>    
    <title>recibo pdf</title>
    <style type="text/css">
        .margin: 0 auto;
        .linha {
            border-color: #bdbdbd;
        }
        .txtcinza {
            color: #607d8b;
        }
        .txtnegrito {
            font-style: inherit;
        }
    </style>

</head>
<body>

<div class="section">
   <!-- <div class="container">
        <div class="row">
            <div class="col l12 m12 s12">
                <h5 class="red yellow-text text-accent-4">CASTELO DO QUEIJO</h5>
                <table>
                    <tr>
                        <td>
                            <label>Rua Manoel Soares, 301, Antônio Bezerra</label><br>
                            <label>Fortaleza/CE</label><br>
                            <label>60360-450</label>
                        </td>
                    
                        <td>
                            <img src="img/dupi.logo.red.png" width="200"><br>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div> -->
    <h4 style="color: #f44336; text-align: center;">CASTELO DO QUEIJO</h4>
    <table>
        <tbody>
            <tr>
                <td>
                    <label style="color: #bdbdbd;">
                        Rua Joaquim Leitão, 301, Antônio Bezerra<br>Fortaleza/CE<br>60360-450
                    </label>
                </td>

                <td>
                    <img src="img/castelo.queijo.jpg" width="200"><br>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- <div class="divider"></div> -->
    <hr class="linha">
    <h3 class="center-align" style="text-align: center;">{{ strtoupper($nomerecibo) }} Nº {{ $venda->id }}</h3>
    <!-- <div class="divider"></div> -->
    <hr class="linha">

    <h6 class="yellow-text text-accent-4">DESTINATÁRIO</h6>
    <table style="font-size: 10px;">
        <tr>
            <td colspan="2">
                <label>Razão Social</label><br>
                <strong>{{ $cliente->nome_rsocial }}</strong>
            </td>
        
            <td>
                <label>CPF/CNPJ</label><br>
                <strong>{{ $cliente->cpf_cnpj }}</strong>
            </td>

            <td>
                <label>E-MAIL</label><br>
                <strong>{{ $cliente->email }}</strong>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <label>NOME FANTASIA</label><br>
                <strong>{{ $cliente->nome_fantasia }}</strong>
            </td>

            <td colspan="2">
                <label>ENDEREÇO</label><br>
                <strong>{{ $cliente->logradouro }}, {{ $cliente->numero }}, {{ $cliente->complemento }}, {{ $cliente->bairro }}</strong>
            </td>
        </tr>
        <tr>
            <td>
                <label>CIDADE</label><br>
                <strong>{{ $cliente->cidade }}/ {{ $cliente->estado }}</strong>
            </td>
            <td>
                <label>CEP</label><br>
                <strong>{{ $cliente->cep }}</strong>
            </td>
            <td>
                <label>TELEFONE PRINCIPAL</label><br>
                <strong>{{ $cliente->tel_principal }}</strong>
            </td>

            <td>
                <label>TELEFONE SECUNDÁRIO</label><br>
                <strong>{{ $cliente->tel_secundario }}</strong>
            </td>
        </tr>
    </table>
    
    <hr style="border-color: #bdbdbd;">

    <h6 class="yellow-text text-accent-4" style="color: #ffd600;">DADOS DA VENDA</h6>
    <table style="font-size: 12px;">
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
                <td>
                    <label class="txtcinza">DATA DE EMISSÃO</label><br>
                    <strong>{{ $venda->created_at }}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="txtcinza">TOTAL DOS ITENS</label><br>
                    <strong>R$ {{ number_format($venda->total_itens, 2, ',', '.') }}</strong>
                </td>
                <td>
                    <label class="txtcinza">TIPO DE DESCONTO</label><br>
                    <strong>{{ $venda->desconto }} em {{ $venda->tipo_desconto }}</strong>
                </td>
                <td>
                    <label class="txtcinza">DESCONTO</label><br>
                    <strong>R$ {{ number_format($venda->total_venda - $venda->total_itens, 2, ',', '.') }}</strong>
                </td>
                <td>
                    <label class="txtcinza">TOTAL</label><br>
                    <strong>R$ {{ number_format($venda->total_venda, 2, ',', '.') }}</strong>
                </td>
            </tr>
        </tbody>
    </table>    
    <br>
    <label style="color: #ffd600;">Itens</label>
    <table class="yellow lighten-4" style="background-color: #fff9c4; border-bottom: 1 dashed #ffffff; border-top: 1 dashed #ffffff;">
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
            @foreach($itens as $item)
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
</div>
</body>
</html>