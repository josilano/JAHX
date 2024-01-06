@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">EDITAR FORMA DE PAGAMENTO</h3>
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
        <a href="{{ route('jahx.formapagamentos') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons purple-text waves-effect">settings</i>
            FORMAS DE PAGAMENTOS
        </a>
    </div>

    <br><br>
    @if(isset($formapag))
        <div class="col l12 m12 s12">
            <form id="form-update-formapag" action="{{ route('jahx.atualizaformapag', ['id' => $formapag->id]) }}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                
                <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600; border-width: 4px;" class="black">
                <legend class="yellow accent-4">Editar Forma de Pagamento</legend>

                <div class="row">
                        <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                            <i class="material-icons yellow-text text-accent-4 prefix">loyalty</i>
                            <input required type="text" id="forma" name="forma" maxlength="60" data-length="60" value="{{ $formapag->forma }}">
                            <label for="forma">Nome da Forma de Pagamento</label>
                        </div>
                    </div>
                </fieldset>
                <br>
                <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit" name="action">Atualizar Forma de Pagamento
                    <i class="material-icons right black-text">send</i>
                </button>
            </form>
        </div>
        @endif

@endsection

@section('rodape')
    @if(isset($formapagsexception))
        @include('erp.partials.msgexception', ['exception' => $formapagsexception])
    @endif

    @if(isset($upformapagexception))
        @include('erp.partials.msgexception', ['exception' => $upformapagexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        //var testemsg = $('#id-teste').val();
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);//'sem cadastro de produtos', 4000);
        }
        //jsteste(testemsg);
    </script>
    
    @if(is_null($formapag))
        <script type="text/javascript">
            msgtela('sem cadastro de formas de pagamentos');
        </script>
    @endif
    
    @if(isset($upformapag))
        @if(!is_numeric($upformapag))
        <script type="text/javascript">
            msgtela('Forma de Pagamento atualizada');
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