<ul class="collapsible" data-collapsible="accordion">
    @foreach($vendas as $venda)
    <li>
        <div class="collapsible-header">@if ($venda->status === 'aberta')<i class="material-icons green-text text-accent-4 prefix">label_outline</i>@elseif($venda->status === 'baixada')<i class="material-icons red-text text-accent-4 prefix">label_outline</i>@else<i class="material-icons orange-text prefix">label_outline</i>@endif
        {{ $venda->id }}<label> Usuário </label>
            {{ $usuario_criador = $venda->users->name }}
            <label> Cliente </label>
            {{ $venda->cliente->nome_rsocial }} - {{ $venda->cliente->nome_fantasia }}
        </div>
        <div class="collapsible-body">
            <div class="row">
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text prefix">drag_handle</i>
                    {{ $venda->status }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-darken-3 prefix">event</i>
                    {{ $venda->created_at }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-lighten-4 prefix">close</i>
                    {{ $venda->parcelas }}
                </div>
            </div>
            <div class="row">
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons black-text prefix">card_membership</i>
                    {{ $venda->forma_pg_venda }}
                </div>

                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                    {{ number_format($venda->total_itens, 2, ',', '.') }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-darken-3 prefix">money_off</i>
                    {{ $venda->tipo_desconto }}
                </div>
            </div>
            <div class="row">
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-darken-3 prefix">money_off</i>
                    {{ $venda->desconto }}
                </div>
                
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                    {{ number_format($venda->total_venda, 2, ',', '.') }}
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12 center-align yellow lighten-5">
                    <i class="material-icons red-text">brush</i>
                    <a class="" href="{{ route('jahx.mostradav', ['id' => $venda->id]) }}">Detalhes</a>
                </div>
            </div>
            <div class="row">
                <div class="col l4 m4 s12 center-align yellow lighten-5">
                    <i class="material-icons red-text">cloud_download</i>
                    <a class="" href="{{ route('jahx.baixarrecibodav', ['id' => $venda->id]) }}">Baixar PDF</a>
                </div>
                <div class="col l4 m4 s12 center-align yellow lighten-5">
                    <i class="material-icons red-text">picture_as_pdf</i>
                    <a class="" href="{{ route('jahx.exibirrecibodav', ['id' => $venda->id]) }}" target="_blanck">Exibir PDF</a>
                </div>
                <div class="col l4 m4 s12 center-align yellow lighten-5">
                    <i class="material-icons red-text">picture_as_pdf</i>
                    <a class="" href="{{ route('jahx.exibircupomdav', ['id' => $venda->id]) }}" target="_blanck">Cupom PDF</a>
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>