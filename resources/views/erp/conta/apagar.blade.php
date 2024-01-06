@extends('erp.template.templateerp')

@section('title', 'JahX Contas a pagar')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">CONTAS A PAGAR</h3>
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
    <ul class="collection with-header">
        <li class="collection-header"><h4>CUSTOS</h4><label class="right">editar</label></li>
    @if (isset($custo_com_pagamento))
        @foreach ($custo_com_pagamento as $custo)
            <li class="collection-item">
                <div class="row">
                    <div class="col l2 m4 s12">{{ $custo->custo }}</div>
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons amber-text text-darken-3 prefix">attach_money</i>
                        <input type="tel" required="required" maxlength="12" id="valor{{ $loop->index }}" name="{{ $custo->custo }}"
                                onKeyUp="maskIt(this,event,'###.###.###,##',true)" onchange="setArrayCustos({{ $loop->index }});"
                                @if (isset($custo->valor)) value="{{ number_format($custo->valor, 2, ',', '.') }}" disabled @endif>
                        <label for="valor">Valor</label>
                    </div>
                    <div class="input-field col l4 m4 s12 teal-text">
                        <i class="material-icons teal-text prefix">event</i>
                        <input type="text" class="datepicker" name="data-pagamento-regcaixa{{ $loop->index }}" 
                            id="data-pagamento-regcaixa{{ $loop->index }}" onchange="setArrayCustos({{ $loop->index }});" 
                            @if (isset($custo->valor)) value="{{ strftime('%d/%m/%Y', strtotime($custo->data_pagamento)) }}" disabled @else value="{{ strftime('%d/%m/%Y') }}" @endif>
                        <label for="data-pagamento-regcaixa">Data do pagamento</label>
                    </div>
                    <div class="col l2 m2 s12">
                        <a href="{{ route('jahx.mostraregistro', ['id' => $custo->id]) }}" class="secondary-content">
                        <i id="icon{{ $loop->index }}" @if (isset($custo->valor)) class="material-icons" @else class="material-icons red-text" @endif>check_circle</i>
                        </a>
                    </div>
                </div>
            </li>
        @endforeach
    @else
        <li class="collection-item">NÃO HÁ CUSTOS CADASTRADOS</li>
    @endif
    </ul>
    <a id="btn-pagar-custos" class="btn amber waves-effect waves-purple purple-text" href="#!" onclick="pagarCustos();" disabled>Pagar custos</a>
    <div class="divider"></div>
    <h5>COMPRAS</h5>
    <table class="striped">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Usuário</th>
                <th>Fornecedor</th>
                <th>Data</th>
                <th>Restante</th>
                <th>Editar</th>
            </tr>
        </thead>

        <tbody>
            @foreach($compras as $compra)
            <tr class="cyan-text text-accent-4">
                <td>{{ $compra->id }}</td>
                <td>{{ $compra->users->name }}</td>
                <td>{{ $compra->fornecedor->nome_rsocial .'-'. $compra->fornecedor->nome_fantasia }}</td>
                <td>{{ strftime('%d/%m/%Y', strtotime($compra->created_at)) }}</td>
                <td>{{ number_format($compra->restante, 2, ',', '.') }}</td>
                <td><a href="{{ route('jahx.editacompra', ['id' => $compra->id]) }}"><i class="material-icons red-text">mode_edit</i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="divider"></div>
    <div class="row">
        <div class="col l6 m6 s12 offset-l6 offset-m6 purple-text right-align">
            <i class="material-icons amber-text">attach_money</i>
            <span class="blue-text">Total de saldo restante a pagar</span> R$ {{ number_format($totalapagar, 2, ',', '.') }}
        </div>
    </div>

    @if (isset($compras))
        @include ('erp.partials.compras.componentelistacompras', ['compras' => $compras])

        @include ('erp.partials.componentepaginacao', ['paginacao' => $compras])
    @endif
    
@endsection

@section('rodape')
    @if(isset($comprasexception))
        @include('erp.partials.msgexception', ['exception' => $comprasexception])
    @endif

    @if(isset($cadcompraexception))
        @include('erp.partials.msgexception', ['exception' => $cadcompraexception])
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
        function pagarCustos(){
            $.ajax({
                url: "/erp/contas-a-pagar",
                type: 'POST',
                data: {
                    user_id: "{{ Auth::user()->id }}",
                    custos: arraycusto,
                    _token: "{{ csrf_token() }}"
                },
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                success: function (response) {
                    window.location.reload();
                    msgtela("Pagamento cadastrado");
                    //debugger;
                    console.log(response);
                },
                error: function (response){
                    msgtela("Algo de errado não está certo!");
                    msgtela("Tente atualizar a página");
                    msgtela("Caso não dê certo, contate o suporte!");
                }
            });
        }

        var arraycusto = [];
        function setArrayCustos(id){
            $('#btn-pagar-custos').attr('disabled', false);
            var existecusto = hasIndexK(arraycusto, $('#valor'+id).attr('name'));
            if (!existecusto)
                arraycusto.push([$('#valor'+id).attr('name'), $('#valor'+id).val(), $('#data-pagamento-regcaixa'+id).val()]);
            else {
                arraycusto[existecusto[0]][existecusto[1]+1] = $('#valor'+id).val();
                arraycusto[existecusto[0]][existecusto[1]+2] = $('#data-pagamento-regcaixa'+id).val();
            }
        }

        function hasIndexK(arr, k){
            for (var i = 0; i < arr.length; i++){
                var index = arr[i].indexOf(k);
                if (index > -1) return [i, index];
            }
            return false;
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