@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">EDITAR FORNECEDOR</h3>
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

    <div class="col l3 m3 s4 yellow-text text-accent-4">
        <a href="{{ route('jahx.fornecedores') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons orange-text text-accent-4 waves-effect">store</i>
            FORNECEDORES
        </a>
    </div>
    <br><br>
    @if(isset($fornecedor))
        <div class="col l12 m12 s12">
            <form id="form-update-fornecedor" action="{{ route('jahx.atualizafornecedor', ['id' => $fornecedor->id]) }}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                
                <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600; border-width: 4px;" class="black">
                <legend class="yellow accent-4">Editar Fornecedor</legend>

                <div class="row">
                    <p>
                        <input class="with-gap" name="pessoa-tipo" type="radio" id="pfop" value="pf" @if ($fornecedor->pessoa_tipo === 'pf') checked @endif />
                        <label for="pfop">PESSOA FÍSICA</label>
                    </p>
                    <p>
                        <input class="with-gap" name="pessoa-tipo" type="radio" id="pjop" value="pj" @if ($fornecedor->pessoa_tipo === 'pj') checked @endif />
                        <label for="pjop">PESSOA JURÍDICA</label>
                    </p>

                    <div class="input-field col s12 m8 l8 yellow-text text-accent-4">
                        <i class="material-icons yellow-text text-accent-4 prefix">business</i>
                        <input required type="text" id="nome-rsocial" name="nome-rsocial" maxlength="60" data-length="60" value="{{ $fornecedor->nome_rsocial }}">
                        <label for="nome-rsocial">Nome/ Razão Social</label>
                    </div>

                    <div class="input-field col s12 m4 l4 yellow-text text-accent-4">
                        <i class="fa fa-address-card prefix" aria-hidden="true"></i>
                        <input required type="text" id="cpf-cnpj" name="cpf-cnpj" maxlength="14" data-length="14" value="{{ $fornecedor->cpf_cnpj }}">
                        <label for="cpf-cnpj">CPF/ CNPJ</label>
                    </div>

                    <div class="input-field col s12 m7 l7 yellow-text text-accent-4">
                        <i class="material-icons prefix">label_outline</i>
                        <input required type="text" id="nome-fantasia" name="nome-fantasia" maxlength="60" data-length="60" value="{{ $fornecedor->nome_fantasia }}">
                        <label for="nome-fantasia">Nome Fantasia</label>
                    </div>

                    <div class="input-field col s12 m5 l5 yellow-text text-accent-4">
                        <i class="material-icons prefix">email</i>
                        <input type="email" id="email" name="email" maxlength="50" data-length="50" value="{{ $fornecedor->email }}">
                        <label for="email">E-mail</label>
                    </div>

                    <div class="input-field col s12 m10 l10 yellow-text text-accent-4">
                        <i class="material-icons prefix">beenhere</i>
                        <input type="text" id="logradouro" name="logradouro" maxlength="60" data-length="60" value="{{ $fornecedor->logradouro }}">
                        <label for="logradouro">Logradouro</label>
                    </div>

                    <div class="input-field col s12 m2 l2 yellow-text text-accent-4">
                        <i class="material-icons prefix">exposure</i>
                        <input type="number" id="numero" name="numero" maxlength="7" data-length="7" value="{{ $fornecedor->numero }}">
                        <label for="numero">Número</label>
                    </div>

                    <div class="input-field col s12 m6 l6 yellow-text text-accent-4">
                        <i class="material-icons prefix">crop_free</i>
                        <input type="text" id="complemento" name="complemento" maxlength="30" data-length="30" value="{{ $fornecedor->complemento }}">
                        <label for="complemento">Complemento</label>
                    </div>

                    <div class="input-field col s12 m6 l6 yellow-text text-accent-4">
                        <i class="material-icons prefix">clear_all</i>
                        <input type="text" id="bairro" name="bairro" maxlength="30" data-length="30" value="{{ $fornecedor->bairro }}">
                        <label for="bairro">Bairro</label>
                    </div>

                    <div class="input-field col s12 m10 l10 yellow-text text-accent-4">
                        <i class="material-icons prefix">location_city</i>
                        <input type="text" id="cidade" name="cidade" maxlength="40" data-length="40" value="{{ $fornecedor->cidade }}">
                        <label for="cidade">Cidade</label>
                    </div>

                    <div class="input-field col s12 m2 l2 yellow-text text-accent-4">
                        <i class="material-icons prefix">location_on</i>
                        <input type="text" id="estado" name="estado" maxlength="2" data-length="2" value="{{ $fornecedor->estado }}">
                        <label for="estado">Estado</label>
                    </div>

                    <div class="input-field col s12 m3 l3 yellow-text text-accent-4">
                        <i class="material-icons prefix">view_stream</i>
                        <input type="number" id="cep" name="cep" maxlength="8" data-length="8" value="{{ $fornecedor->cep }}">
                        <label for="cep">CEP</label>
                    </div>

                    <div class="input-field col s12 m5 l5 yellow-text yellow-text">
                        <i class="material-icons prefix">phone_iphone</i>
                        <input type="tel" id="tel-principal" name="tel-principal" maxlength="15" data-length="15" value="{{ $fornecedor->tel_principal }}">
                        <label for="tel-principal">Telefone Principal</label>
                    </div>

                    <div class="input-field col s12 m4 l4 yellow-text text-accent-4">
                        <i class="material-icons prefix">phone</i>
                        <input type="text" id="tel-secundario" name="tel-secundario" maxlength="15" data-length="15" value="{{ $fornecedor->tel_secundario }}">
                        <label for="tel-secundario">Telefone secundário</label>
                    </div>
                </div>
                </fieldset>
                <br>
                <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit" name="action">Atualizar Fornecedor
                    <i class="material-icons right black-text">send</i>
                </button>
            </form>
        </div>
        @endif

@endsection

@section('rodape')
    @if(isset($fornecedorexception))
        @include('erp.partials.msgexception', ['exception' => $fornecedorexception])
    @endif

    @if(isset($upfornecedorexception))
        @include('erp.partials.msgexception', ['exception' => $upfornecedorexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    @if(is_null($fornecedor))
        <script type="text/javascript">
            //var testemsg = $('#id-teste').val();
            msgtela('fornecedor inexistente');
        </script>
    @endif
    
    @if(isset($upfornecedor))
        @if(!is_numeric($upfornecedor))
        <script type="text/javascript">
            msgtela('Fornecedor atualizado');
        </script>
        @endif
    @else
        <script type="text/javascript">
            msgtela('Erro na atualização');
        </script>
    @endif

    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
@endsection