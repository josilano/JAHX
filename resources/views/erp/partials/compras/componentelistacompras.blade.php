<ul class="collapsible" data-collapsible="accordion">
    @foreach($compras as $compra)
    <li>
        <div class="collapsible-header">@if ($compra->status === 'finalizada')<i class="material-icons yellow-text text-accent-4 prefix">label_outline</i>@elseif($compra->status === 'cancelada')<i class="material-icons red-text text-accent-4 prefix">label_outline</i>@else<i class="material-icons orange-text prefix">label_outline</i>@endif
        {{ $compra->id }}<label> Usuário </label>
            {{ $usuario_criador = $compra->users->name }}
            <label> Fornecedor </label>
            {{ $compra->fornecedor->nome_rsocial }} - {{ $compra->fornecedor->nome_fantasia }}
        </div>
        <div class="collapsible-body">
            <div class="row">
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text prefix">drag_handle</i>
                    {{ $compra->status }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-darken-3 prefix">event</i>
                    {{ $compra->created_at }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-lighten-4 prefix">close</i>
                    {{ $compra->parcelas }}
                </div>
            </div>
            <div class="row">
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons black-text prefix">card_membership</i>
                    {{ $compra->forma_pg_compra }}
                </div>

                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                    {{ number_format($compra->total_compra, 2, ',', '.') }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-darken-3 prefix">money_off</i>
                    {{ strftime('%d/%m/%Y', strtotime($compra->data_emissao)) }}
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12 center-align yellow lighten-5">
                    <i class="material-icons red-text">brush</i>
                    <a class="" href="{{ route('jahx.mostracompra', ['id' => $compra->id]) }}">Detalhes</a>
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>