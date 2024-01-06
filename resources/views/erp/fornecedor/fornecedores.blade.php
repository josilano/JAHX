@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">FORNECEDORES</h3>
        <table class="highlight yellow-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Fornecedores Cadastrados</td>
                    <td>@if(isset($fornecedores)){{ $fornecedores->total() }}@endif</td>
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

    <div class="row">
        <div class="col s12">
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">search</i>
              <input type="text" id="autocomplete-input" class="autocomplete">
              <label for="autocomplete-input">Buscar</label>
            </div>
          </div>
        </div>
    </div>

        <ul class="collapsible black" data-collapsible="accordion">
            <li>
                <div class="collapsible-header yellow accent-4"><i class="material-icons">filter_drama</i>Cadastrar Fornecedor</div>
                <div class="collapsible-body">
                    <form id="form-create-veiculo" action="{{ route('jahx.addfornecedor') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" id="pessoa-id" name="pessoa-id" value="{ $pessoa_id }}">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;">
                        <legend class="yellow-text text-accent-4">Dados do Fornecedor</legend>
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
                    <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit" name="action">Cadastrar Fornecedor
                        <i class="material-icons right">send</i>
                    </button>
                    </form>

                </div>
            </li>
        </ul>

        @if (isset($fornecedores))

        <ul class="collapsible" data-collapsible="accordion">
            @foreach ($fornecedores as $fornecedor)
            <li>
                <div class="collapsible-header">
                    <i class="material-icons yellow-text text-accent-4 prefix">business</i>
                    {{ $fornecedor->nome_rsocial }}
                </div>
                <div class="collapsible-body">
                    <div class="row">
                        @if ($fornecedor->pessoa_tipo === 'pf')
                            <p>
                                <input class="with-gap" name="pessoa-tipo" type="radio" id="pfop" value="pf" checked />
                                <label for="pfop">PESSOA FÍSICA</label>
                            </p>
                        @else
                            <p>
                                <input class="with-gap" name="pessoa-tipo" type="radio" id="pjop" value="pj" checked />
                                <label for="pjop">PESSOA JURÍDICA</label>
                            </p>
                        @endif
                    </div>

                    <div class="row cyan-text text-accent-4">
                        <div class="col s4 m4 l4">
                            <i class="fa fa-address-card prefix" aria-hidden="true"></i>
                            {{ $fornecedor->cpf_cnpj }}
                        </div>
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">label_outline</i>
                            {{ $fornecedor->nome_fantasia }}
                        </div>
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">email</i>
                            {{ $fornecedor->email }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">beenhere</i>
                            {{ $fornecedor->logradouro }}
                        </div>
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">exposure</i>
                            {{ $fornecedor->numero }}
                        </div>
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">crop_free</i>
                            {{ $fornecedor->complemento }}
                        </div>
                    </div>
                    <div class="row cyan-text text-accent-4">
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">clear_all</i>
                            {{ $fornecedor->bairro }}
                        </div>
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">location_city</i>
                            {{ $fornecedor->cidade }}
                        </div>
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">location_on</i>
                            {{ $fornecedor->estado }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">view_stream</i>
                            {{ $fornecedor->cep }}
                        </div>
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">phone_iphone</i>
                            {{ $fornecedor->tel_principal }}
                        </div>
                        <div class="col s4 m4 l4">
                            <i class="material-icons prefix">phone</i>
                            {{ $fornecedor->tel_secundario }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l12 m12 s12 center-align yellow lighten-5">
                            <i class="material-icons red-text">mode_edit</i>
                            <a class="" href="{{ route('jahx.mostrafornecedor', ['id' => $fornecedor->id]) }}">Editar</a>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>

        @include('erp.partials.componentepaginacao', ['paginacao' => $fornecedores])

        @endif
    
@endsection

@section('rodape')
    @if(isset($fornecedoresexception))
        @include('erp.partials.msgexception', ['exception' => $fornecedoresexception])
    @endif

    @if(isset($cadfornecedorexception))
        @include('erp.partials.msgexception', ['exception' => $cadfornecedorexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    @if(is_null($fornecedores))
        <script type="text/javascript">
            msgtela('sem cadastro de fornecedores');
        </script>
    @endif
    
    @if(isset($cadfornecedor))
        @if(!is_numeric($cadfornecedor))
        <script type="text/javascript">
            msgtela('Fornecedor cadastrado');
        </script>
        @endif
    @else
        <script type="text/javascript">
            msgtela('Erro no cadastro');
        </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function() {
            $('input.autocomplete').autocomplete({
            data: {
              @foreach($fornecedores as $fornecedor)
              "{{ $fornecedor->nome_rsocial }}": null,
              @endforeach
            },
            limit: 20,
            onAutocomplete: function(slug) {
                $.ajax({
                    url: "/erp/fornecedores/q="+slug,
                    type: 'GET',
                    //data: {slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        window.location.replace("/erp/fornecedores/q="+slug);
                        debugger;
                        console.log(slug);
                    }
                });
            },
            minLength: 1,
          });
        });
    </script>

    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
@endsection