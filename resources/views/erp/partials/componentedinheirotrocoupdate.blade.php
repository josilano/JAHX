<div class="row">
    <div class="input-field col s12 m4 l2">
        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
            <legend>Valor Cartão</legend>
            <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
            <input type="tel" id="valor-cartao" name="valor-cartao" @if (isset($suprimento)) value="{{ number_format($suprimento[0]->valor, 2, ',', '.') }}" @else value='0' disabled @endif
            onKeyUp="maskIt(this,event,'###.###.###,##',true)" onchange="calculaTotalDinheiroCartao()">
        </fieldset>
    </div>
    <div class="input-field col s12 m4 l2 offset-l6">
        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
            <legend>Dinheiro</legend>
            <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
            <input type="tel" id="dinheiro" name="dinheiro" onKeyUp="maskIt(this,event,'###.###.###,##',true)" onchange="calculaTroco()" value="{{ number_format($vtemp->dinheiro, 2, ',', '.') }}">
        </fieldset>
    </div>
    <div class="col l2 m4 s12">
        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
            <legend>Troco</legend>
            <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
            <input type="hidden" name="troco" id="troco" value="{{ number_format($vtemp->troco, 2, ',', '.') }}">
            <span class="troco">{{ number_format($vtemp->troco, 2, ',', '.') }}</span>
        </fieldset>
    </div>
    <div class="input-field col s12 m4 l2 offset-l8 offset-m4">
        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
            <legend>Restante</legend>
            <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
            <input type="tel" id="restante" name="restante" onKeyUp="maskIt(this,event,'###.###.###,##',true)" value="{{ number_format($vtemp->restante, 2, ',', '.') }}">
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="input-field col l12 m12 s12">
        <i class="material-icons amber-text text-accent-4 prefix">description</i>
        <textarea id="observacoes" name="observacoes" class="materialize-textarea" data-length="155" maxlength="155">{{ $vtemp->observacoes }}</textarea>
        <label for="observacoes">Observações</label>
    </div>
</div>