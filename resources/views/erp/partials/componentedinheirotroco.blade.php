<div class="row">
    <div class="input-field col s12 m4 l2">
        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
            <legend>Valor Cartão</legend>
            <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
            <input type="tel" id="valor-cartao" name="valor-cartao" value="0" onKeyUp="maskIt(this,event,'###.###.###,##',true)" onchange="calculaTotalDinheiroCartao()" disabled>
        </fieldset>
    </div>
    <div class="input-field col s12 m4 l2 offset-l6">
        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
            <legend>Dinheiro</legend>
            <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
            <input type="tel" id="dinheiro" name="dinheiro" onKeyUp="maskIt(this,event,'###.###.###,##',true)" onchange="calculaTroco()">
        </fieldset>
    </div>
    <div class="col l2 m4 s12">
        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
            <legend>Troco</legend>
            <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
            <input type="hidden" name="troco" id="troco" value="0,00">
            <span class="troco">0,00</span>
        </fieldset>
    </div>
    <div class="input-field col s12 m4 l2 offset-l8 offset-m4">
        <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
            <legend>Restante</legend>
            <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
            <input type="tel" id="restante" name="restante" onKeyUp="maskIt(this,event,'###.###.###,##',true)" value="0,00">
        </fieldset>
    </div>
</div>
<div class="row">
    <div class="input-field col l12 m12 s12">
        <i class="material-icons amber-text text-accent-4 prefix">description</i>
        <textarea id="observacoes" name="observacoes" class="materialize-textarea" data-length="155" maxlength="155"></textarea>
        <label for="observacoes">Observações</label>
    </div>
</div>