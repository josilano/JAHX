<ul class="collapsible black" data-collapsible="accordion">
    <li>
        <div class="collapsible-header yellow accent-4"><i class="material-icons">filter_drama</i>Cadastrar Cliente</div>
        <div class="collapsible-body">
            <form id="form-create-veiculo" action="{{ route('jahx.addcliente') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}">
            <fieldset style="border-radius: 20px; border-color: #ffd600;">
                <legend class="yellow-text text-accent-4">Dados do Cliente</legend>
                <div class="row">
                    <p>
                        <input class="with-gap" name="pessoa-tipo" type="radio" id="pfop" value="pf" checked />
                        <label for="pfop">PESSOA FÍSICA</label>
                    </p>
                    <p>
                        <input class="with-gap" name="pessoa-tipo" type="radio" id="pjop" value="pj"  />
                        <label for="pjop">PESSOA JURÍDICA</label>
                    </p>

                    <div class="input-field col s12 m8 l8 yellow-text text-accent-4">
                        <i class="material-icons yellow-text text-accent-4 prefix">business</i>
                        <input required type="text" id="nome-rsocial" name="nome-rsocial" maxlength="60" data-length="60">
                        <label for="nome-rsocial">Nome/ Razão Social</label>
                    </div>

                    <div class="input-field col s12 m4 l4 yellow-text text-accent-4">
                        <i class="fa fa-address-card prefix" aria-hidden="true"></i>
                        <input required type="text" id="cpf-cnpj" name="cpf-cnpj" maxlength="14" data-length="14">
                        <label for="cpf-cnpj">CPF/ CNPJ</label>
                    </div>

                    <div class="input-field col s12 m7 l7 yellow-text text-accent-4">
                        <i class="material-icons prefix">label_outline</i>
                        <input required type="text" id="nome-fantasia" name="nome-fantasia" maxlength="60" data-length="60">
                        <label for="nome-fantasia">Nome Fantasia</label>
                    </div>

                    <div class="input-field col s12 m5 l5 yellow-text text-accent-4">
                        <i class="material-icons prefix">email</i>
                        <input type="email" id="email" name="email" maxlength="50" data-length="50">
                        <label for="email">E-mail</label>
                    </div>

                    <div class="input-field col s12 m10 l10 yellow-text text-accent-4">
                        <i class="material-icons prefix">beenhere</i>
                        <input type="text" id="logradouro" name="logradouro" maxlength="60" data-length="60">
                        <label for="logradouro">Logradouro</label>
                    </div>

                    <div class="input-field col s12 m2 l2 yellow-text text-accent-4">
                        <i class="material-icons prefix">exposure</i>
                        <input type="number" id="numero" name="numero" maxlength="7" data-length="7">
                        <label for="numero">Número</label>
                    </div>

                    <div class="input-field col s12 m6 l6 yellow-text text-accent-4">
                        <i class="material-icons prefix">crop_free</i>
                        <input type="text" id="complemento" name="complemento" maxlength="30" data-length="30">
                        <label for="complemento">Complemento</label>
                    </div>

                    <div class="input-field col s12 m6 l6 yellow-text text-accent-4">
                        <i class="material-icons prefix">clear_all</i>
                        <input type="text" id="bairro" name="bairro" maxlength="30" data-length="30">
                        <label for="bairro">Bairro</label>
                    </div>

                    <div class="input-field col s12 m10 l10 yellow-text text-accent-4">
                        <i class="material-icons prefix">location_city</i>
                        <input type="text" id="cidade" name="cidade" maxlength="40" data-length="40">
                        <label for="cidade">Cidade</label>
                    </div>

                    <div class="input-field col s12 m2 l2 yellow-text text-accent-4">
                        <i class="material-icons prefix">location_on</i>
                        <input type="text" id="estado" name="estado" maxlength="2" data-length="2">
                        <label for="estado">Estado</label>
                    </div>

                    <div class="input-field col s12 m3 l3 yellow-text text-accent-4">
                        <i class="material-icons prefix">view_stream</i>
                        <input type="number" id="cep" name="cep" maxlength="8" data-length="8">
                        <label for="cep">CEP</label>
                    </div>

                    <div class="input-field col s12 m5 l5 yellow-text yellow-text">
                        <i class="material-icons prefix">phone_iphone</i>
                        <input type="tel" id="tel-principal" name="tel-principal" maxlength="15" data-length="15">
                        <label for="tel-principal">Telefone Principal</label>
                    </div>

                    <div class="input-field col s12 m4 l4 yellow-text text-accent-4">
                        <i class="material-icons prefix">phone</i>
                        <input type="text" id="tel-secundario" name="tel-secundario" maxlength="15" data-length="15">
                        <label for="tel-secundario">Telefone secundário</label>
                    </div>
                </div>
            </fieldset>
            <br>
            <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit" name="action">Cadastrar Cliente
                <i class="material-icons right">send</i>
            </button>
            </form>
        </div>
    </li>
</ul>