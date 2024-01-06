<ul class="">
    <li>
    <div class="cyan-text text-accent-4 valign-wrapper">
        <label>Número </label>
        <i class="material-icons yellow-text text-accent-4 prefix">label_outline</i>
        {{ $venda->id }}
        <label>Setor </label>
        <i class="material-icons yellow-text text-accent-4 prefix">business_center</i>
        {{ $venda->setor_venda }}
        <label>Usuário </label>
        <i class="material-icons yellow-text text-accent-4 prefix">hot_tub</i>
        {{ $usuario_criador }}
    </div>
        <div class="">
            <div class="row amber lighten-4">
                <label class="col l4">Status</label>
                <label class="col l4">Data de emissão</label>
                <label class="col l4">Parcelas</label>
            </div>
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
            <div class="row amber lighten-4">
                <label class="col l3">Forma de pagamento</label>
                <label class="col l3">Total dos itens</label>
                <label class="col l3">Tipo de desconto</label>
                <label class="col l3">Desconto</label>
            </div>
            <div class="row">
                <div class="col s3 m3 l3 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons black-text prefix">card_membership</i>
                    {{ $venda->forma_pg_venda }}
                </div>

                <div class="col s3 m3 l3 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                    {{ number_format($venda->total_itens, 2, ',', '.') }}
                </div>
                <div class="col s3 m3 l3 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-darken-3 prefix">money_off</i>
                    {{ $venda->tipo_desconto }}
                </div>
                <div class="col s3 m3 l3 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-darken-3 prefix">money_off</i>
                    {{ $venda->desconto }}
                </div>
            </div>
            <div class="row amber lighten-4">
                <label class="col l4">Total</label>
                <label class="col l4">Dinheiro</label>
                <label class="col l4">Troco</label>
            </div>
            <div class="row">
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                    {{ number_format($venda->total_venda, 2, ',', '.') }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                    {{ number_format($venda->dinheiro, 2, ',', '.') }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                    {{ number_format($venda->troco, 2, ',', '.') }}
                </div>
            </div>
            
            <div class="row amber lighten-4">
                <label class="col l12">Observações</label>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <i class="material-icons yellow-text text-accent-4 prefix">description</i>
                    {{ $venda->observacoes }}
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12 center-align yellow lighten-5">
                    <i class="material-icons red-text">mode_edit</i>
                    <a class="" href="{{ route('jahx.editadav', ['id' => $venda->id]) }}">Editar</a>
                </div>
            </div>
        </div>
    </li>
</ul>