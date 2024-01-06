<ul class="collapsible" data-collapsible="accordion">
    @foreach ($clientes as $cliente)
    <li>
        <div class="collapsible-header">
        @if ($cliente->status === 'inativo')
            <i class="material-icons red-text text-accent-4 prefix">business</i>
            <span class="red-text text-accent-4">{{ $cliente->nome_rsocial }}</span>
        @else
            <i class="material-icons yellow-text text-accent-4 prefix">business</i>
            {{ $cliente->nome_rsocial }}
        @endif
        </div>
        <div class="collapsible-body">
            <div class="row">
                <div class="col l6 m6 s12">
                @if ($cliente->pessoa_tipo === 'pf')
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
                <div class="col l6 m6 s12">
                    <span class="cyan-text text-accent-4">{{ strtoupper($cliente->status) }}</span>
                </div>
            </div>

            <div class="row cyan-text text-accent-4">
                <div class="col s4 m4 l4">
                    <i class="fa fa-address-card prefix" aria-hidden="true"></i>
                    {{ $cliente->cpf_cnpj }}
                </div>
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">label_outline</i>
                    {{ $cliente->nome_fantasia }}
                </div>
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">email</i>
                    {{ $cliente->email }}
                </div>
            </div>
            <div class="row">
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">beenhere</i>
                    {{ $cliente->logradouro }}
                </div>
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">exposure</i>
                    {{ $cliente->numero }}
                </div>
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">crop_free</i>
                    {{ $cliente->complemento }}
                </div>
            </div>
            <div class="row cyan-text text-accent-4">
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">clear_all</i>
                    {{ $cliente->bairro }}
                </div>
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">location_city</i>
                    {{ $cliente->cidade }}
                </div>
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">location_on</i>
                    {{ $cliente->estado }}
                </div>
            </div>
            <div class="row">
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">view_stream</i>
                    {{ $cliente->cep }}
                </div>
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">phone_iphone</i>
                    {{ $cliente->tel_principal }}
                </div>
                <div class="col s4 m4 l4">
                    <i class="material-icons prefix">phone</i>
                    {{ $cliente->tel_secundario }}
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12 center-align yellow lighten-5">
                    <i class="material-icons red-text">mode_edit</i>
                    <a class="" href="{{ route('jahx.mostracliente', ['id' => $cliente->id]) }}">Editar</a>
                </div>
            </div>
        </div>
    </li>
    @endforeach
</ul>