@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')
            
    <div class="col l12 m12 s12 black">
        <h3 class="amber-text text-accent-4 center-align">CUSTOS</h3>
        <table class="highlight amber-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Custos Cadastrados</td>
                    <td>@if(isset($custos)){{ $custos->total() }}@endif</td>
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
            <div class="collapsible-header amber accent-4"><i class="material-icons">filter_drama</i>Cadastrar Custo</div>
            <div class="collapsible-body black">
                <form id="form-create-custo" action="{{ route('jahx.addcusto') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="user-id" name="usuario-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600;">
                    <legend class="purple-text text-darken-3 amber-text text-accent-4">Dados do Custo</legend>
                    <div class="row">
                        <div class="input-field col s12 m12 l12 amber-text text-accent-4">
                            <i class="material-icons amber-text text-accent-4 prefix">loyalty</i>
                            <input required type="text" id="custo" name="custo" maxlength="100" data-length="100">
                            <label for="custo">Nome do Custo</label>
                        </div>
                    </div>
                </fieldset>
                <br>
                <button class="btn waves-effect waves-light amber accent-4 black-text" type="submit" name="action">Cadastrar Custo
                    <i class="material-icons right black-text">send</i>
                </button>
                </form>
            </div>
        </li>
    </ul>

    @if(isset($custos))
        <ul class="collapsible" data-collapsible="accordion">
            @foreach($custos as $custo)
            <li>
                <div class="collapsible-header">
                    <i class="material-icons amber-text text-accent-4 prefix">loyalty</i>
                    {{ $custo->custo }}
                </div>
                <div class="collapsible-body">
                    <div class="row">
                        <div class="col s6 m6 l6 cyan-text text-accent-4">
                            <i class="fa fa-id-card purple-text text-darken-3 prefix" aria-hidden="true"></i>
                            {{ $custo->id }}
                        </div>
                        <div class="col s6 m6 l6 cyan-text text-accent-4">
                            <i class="material-icons red-text text-lighten-1 prefix">loyalty</i>
                            {{ $custo->custo }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l12 m12 s12 center-align amber lighten-5">
                            <i class="material-icons red-text">mode_edit</i>
                            <a class="" href="{{ route('jahx.mostracusto', ['id' => $custo->id]) }}">Editar</a>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>

        @include('erp.partials.componentepaginacao', ['paginacao' => $custos])
        
    @endif

@endsection

@section('rodape')
    @if(isset($custosexception))
        @include('erp.partials.msgexception', ['exception' => $custosexception])
    @endif


    @if(isset($cadcustoexception))
        @include('erp.partials.msgexception', ['exception' => $cadcustoexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    
    @if(is_null($custos))
        <script type="text/javascript">
            msgtela('sem cadastro de custos');
        </script>
    @endif
    
    @if(isset($cadcusto))
        @if(!is_numeric($cadcusto))
        <script type="text/javascript">
            msgtela('Custo cadastrado');
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
              @foreach($custosall as $custo)
              "{{ $custo->custo }}": null,
              @endforeach
            },
            limit: 20, 
            onAutocomplete: function(slug) {
                window.location.replace("/erp/ajustes/custos/q="+slug);
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