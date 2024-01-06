<ul class="collapsible" data-collapsible="accordion">
    @foreach($registros_caixa as $caixa)
    <li>
        <div class="collapsible-header">@if ($caixa->operacao === 'Sangria')<i class="material-icons red-text text-accent-4 prefix">label_outline</i>@else <i class="material-icons green-text text-accent-4 prefix">label_outline</i>@endif
            <label>Usuário</label>
            {{ $caixa->users->name }}
            <label>Descrição </label><span>{{ $caixa->descricao }}</span>
        </div>
        <div class="collapsible-body">
            <div class="row">
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text prefix">drag_handle</i>
                    {{ $caixa->operacao }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-darken-3 prefix">event</i>
                    {{ strftime('%d/%m/%Y %H-%M-%S', strtotime($caixa->created_at)) }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-lighten-4 prefix">close</i>
                    {{ $caixa->descricao }}
                </div>
            </div>
            <div class="row">
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons yellow-text text-accent-4 prefix">attach_money</i>
                    {{ number_format($caixa->valor, 2, ',', '.') }}
                </div>
                <div class="col s4 m4 l4 cyan-text text-accent-4 valign-wrapper">
                    <i class="material-icons purple-text text-lighten-4 prefix">close</i>
                    {{ $caixa->id }}
                </div>
            </div>
            <div class="row">
                <div class="col l6 m6 s12 center-align yellow lighten-5">
                    <i class="material-icons red-text">edit</i>
                    <a class="" href="{{ route('jahx.mostraregistro', ['id' => $caixa->id]) }}">Editar</a>
                </div>
                <div class="col l6 m6 s12 center-align yellow lighten-5">
                    <i class="material-icons red-text">delete</i>
                    <a class="" href="#modal-confirma-delete" onclick="setCaixaIdToExcluir({{ $caixa->id }});">Excluir</a>
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>
<div id="modal-confirma-delete" class="modal">
    <div class="modal-content">
        <h4>Confirma exclusão</h4>
        <p class="purple-text">REALMENTE DESEJA EXLUIR O REGISTRO DO CAIXA?</p>
    </div>
    <div class="modal-footer">
        <a href="#!" onclick="$('#modal-confirma-delete').modal('close');">CANCELAR</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="excluirCaixa();">SIM!</a>
    </div>
</div>