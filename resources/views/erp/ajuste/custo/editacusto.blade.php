@extends('erp.template.templateerp')

@section('title', 'JahX Custos')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="amber-text text-accent-4 center-align">EDITAR CUSTO</h3>
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

    <div class="col l3 m3 s4 amber-text text-accent-4">
        <a href="{{ route('jahx.custos') }}" class="amber-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons purple-text waves-effect">sentiment_dissatisfied</i>
            CUSTOS
        </a>
    </div>

    <br><br>
    @if(isset($custo))
        <div class="col l12 m12 s12">
            <form id="form-update-custo" action="{{ route('jahx.atualizacusto', ['id' => $custo->id]) }}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                
                <input type="hidden" id="user-id" name="usuario-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600; border-width: 4px;" class="black">
                <legend class="amber accent-4">Editar Custo</legend>

                <div class="row">
                        <div class="input-field col s12 m12 l12 amber-text text-accent-4">
                            <i class="material-icons amber-text text-accent-4 prefix">loyalty</i>
                            <input required type="text" id="custo" name="custo" maxlength="100" data-length="100" value="{{ $custo->custo }}">
                            <label for="custo">Nome do Custo</label>
                        </div>
                    </div>
                </fieldset>
                <br>
                <button class="btn waves-effect waves-light amber accent-4 black-text" type="submit">Atualizar Custo
                    <i class="material-icons right black-text">send</i>
                </button>
            </form>
        </div>
        @endif

@endsection

@section('rodape')
    @if(isset($custosexception))
        @include('erp.partials.msgexception', ['exception' => $custosexception])
    @endif

    @if(isset($upcustoexception))
        @include('erp.partials.msgexception', ['exception' => $upcustoexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    
    @if(is_null($custo))
        <script type="text/javascript">
            msgtela('sem cadastro de custos');
        </script>
    @endif
    
    @if(isset($upcusto))
        @if(!is_numeric($upcusto))
        <script type="text/javascript">
            msgtela('Custo atualizado');
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