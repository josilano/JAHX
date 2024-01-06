<ul class="">
    <li>
        <div class="cyan-text text-accent-4 valign-wrapper">
            <label>Número </label>
            <i class="material-icons yellow-text text-accent-4 prefix">label_outline</i>
            {{ $compra->id }}
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
                    {{ $compra->status }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-darken-3 prefix">event</i>
                    {{ strftime('%d/%m/%Y', strtotime($compra->data_emissao)) }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-lighten-4 prefix">close</i>
                    {{ $compra->parcelas }}
                </div>
            </div>
            <div class="row amber lighten-4">
                <label class="col l4">Forma de pagamento</label>
                <label class="col l4">Número da nota</label>
                <label class="col l4">Data do cadastro</label>
            </div>
            <div class="row">
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons black-text prefix">card_membership</i>
                    {{ $compra->forma_pg_compra }}
                </div>

                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                    {{ $compra->numero_nota }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-darken-3 prefix">event</i>
                    {{ $compra->created_at }}
                </div>
            </div>
            <div class="row amber lighten-4">
                <label class="col l4">Total</label>
            </div>
            <div class="row">
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                    {{ number_format($compra->total_compra, 2, ',', '.') }}
                </div>
            </div>
            @if ($compra->status != 'cancelada')
            <div class="row">
                <div class="col l12 m12 s12 center-align yellow lighten-5">
                    <i class="material-icons red-text">mode_edit</i>
                    <a class="" href="{{ route('jahx.editacompra', ['id' => $compra->id]) }}">Editar</a>
                </div>
            </div>
            @endif
        </div>
    </li>
</ul>