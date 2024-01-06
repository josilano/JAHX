<div class="row">
    <div class="col l6 m6 s6">
        <i class="material-icons yellow-text text-accent-4 prefix">business</i>
        <label id="nome_rsocial">{{ $cliente->nome_rsocial }}</label>
    </div>
    <div class="col l6 m6 s6">
        <label id="pessoa_tipo">{{ $cliente->pessoa_tipo }}</label>
    </div>
</div>

<div class="row cyan-text text-accent-4">
    <div class="col s4 m4 l4">
        <i class="fa fa-address-card prefix" aria-hidden="true"></i>
        <label id="cpf_cnpj">{{ $cliente->cpf_cnpj }}</label>
    </div>
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">label_outline</i>
        <label id="nome_fantasia">{{ $cliente->nome_fantasia }}</label>
    </div>
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">email</i>
        <label id="email">{{ $cliente->email }}</label>
    </div>
</div>
<div class="row">
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">beenhere</i>
        <label id="logradouro">{{ $cliente->logradouro }}</label>
    </div>
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">exposure</i>
        <label id="numero">{{ $cliente->numero }}</label>
    </div>
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">crop_free</i>
        <label id="complemento">{{ $cliente->complemento }}</label>
    </div>
</div>
<div class="row cyan-text text-accent-4">
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">clear_all</i>
        <label id="bairro">{{ $cliente->bairro }}</label>
    </div>
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">location_city</i>
        <label id="cidade">{{ $cliente->cidade }}</label>
    </div>
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">location_on</i>
        <label id="estado">{{ $cliente->estado }}</label>
    </div>
</div>
<div class="row">
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">view_stream</i>
        <label id="cep">{{ $cliente->cep }}</label>
    </div>
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">phone_iphone</i>
        <label id="tel_principal">{{ $cliente->tel_principal }}</label>
    </div>
    <div class="col s4 m4 l4">
        <i class="material-icons prefix">phone</i>
        <label id="tel_secundario">{{ $cliente->tel_secundario }}</label>
    </div>
</div>
<div class="row">
    <div class="col l12 m12 s12 center-align yellow lighten-5">
        <i class="material-icons red-text">mode_edit</i>
        <a class="linkeditarcliente" @if (isset($fornecedor)) href="{{ route('jahx.mostrafornecedor', ['id' => $cliente->id]) }}" @else href="{{ route('jahx.mostracliente', ['id' => $cliente->id]) }}" @endif>Editar</a>
    </div>
</div>