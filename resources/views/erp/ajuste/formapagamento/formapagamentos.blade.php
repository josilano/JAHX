@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')
            
    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">FORMA DE PAGAMENTOS</h3>
        <table class="highlight yellow-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Formas de Pagamentos Cadastradas</td>
                    <td>@if(isset($formapags)){{ $formapags->total() }}@endif</td>
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
    
    <div class="col l3 m3 s4 yellow-text text-accent-4">
        <a href="{{ route('jahx.ajustes') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons purple-text waves-effect">settings</i>
            AJUSTES
        </a>
    </div>

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
        

    <ul class="collapsible" data-collapsible="accordion">
        <li>
            <div class="collapsible-header yellow accent-4"><i class="material-icons">filter_drama</i>Cadastrar Forma de Pagamento</div>
            <div class="collapsible-body black">
                <form id="form-create-veiculo" action="{{ route('jahx.addformapag') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600;">
                    <legend class="purple-text text-darken-3 yellow-text text-accent-4">Dados da Forma de Pagamento</legend>
                    <div class="row">
                        <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                            <i class="material-icons yellow-text text-accent-4 prefix">loyalty</i>
                            <input required type="text" id="forma" name="forma" maxlength="60" data-length="60">
                            <label for="forma">Nome da Forma de Pagamento</label>
                        </div>
                    </div>
                </fieldset>
                <br>
                <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit" name="action">Cadastrar Forma de Pagamento
                    <i class="material-icons right black-text">send</i>
                </button>
                </form>
            </div>
        </li>
    </ul>

    @if(isset($formapags))
        <ul class="collapsible" data-collapsible="accordion">
            @foreach($formapags as $fpg)
            <li>
                <div class="collapsible-header">
                    <i class="material-icons yellow-text text-accent-4 prefix">loyalty</i>
                    {{ $fpg->forma }}
                </div>
                <div class="collapsible-body">
                    <div class="row">
                        <div class="col s6 m6 l6 cyan-text text-accent-4">
                            <i class="fa fa-id-card purple-text text-darken-3 prefix" aria-hidden="true"></i>
                            {{ $fpg->id }}
                        </div>
                        <div class="col s6 m6 l6 cyan-text text-accent-4">
                            <i class="material-icons red-text text-lighten-1 prefix">loyalty</i>
                            {{ $fpg->forma }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l12 m12 s12 center-align yellow lighten-5">
                            <i class="material-icons red-text">mode_edit</i>
                            <a class="" href="{{ route('jahx.mostraformapag', ['id' => $fpg->id]) }}">Editar</a>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>

        @include('erp.partials.componentepaginacao', ['paginacao' => $formapags])
        
    @endif

@endsection

@section('rodape')
    @if(isset($formapagsexception))
        @include('erp.partials.msgexception', ['exception' => $formapagsexception])
    @endif


    @if(isset($cadformapagexception))
        @include('erp.partials.msgexception', ['exception' => $cadformapagexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    
    @if(is_null($formapags))
        <script type="text/javascript">
            msgtela('sem cadastro de formas de pagamento');
        </script>
    @endif
    
    @if(isset($cadformapag))
        @if(!is_numeric($cadformapag))
        <script type="text/javascript">
            msgtela('Forma de Pagamento cadastrada');
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
              @foreach($formapagsall as $fpg)
              "{{ $fpg->forma }}": null,
              @endforeach
            },
            limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
            onAutocomplete: function(slug) {
                // Callback function when value is autcompleted.

                $.ajax({
                    //url: "{{ route('jahx.mostraprodutodescricao', ['' => 'ovo']) }}",
                    url: "/erp/ajustes/formapagamentos/q="+slug,
                    type: 'GET',
                    //data: {slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        window.location.replace("/erp/ajustes/formapagamentos/q="+slug);
                        debugger;
                        console.log(slug);
                    }
                });
            },
            minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
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