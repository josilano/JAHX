@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="yellow-text text-accent-4 center-align">ALTERAR PERMISSÃO DE USUÁRIO</h3>
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
        <a href="{{ route('jahx.usuarios') }}" class="yellow-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="tiny material-icons purple-text waves-effect">settings</i>
            USUÁRIOS
        </a>
    </div>

    <br><br>
    @if(isset($usuario))
        <div class="col l12 m12 s12">
            <form id="form-update-usuario" action="{{ route('jahx.alterapermissaousuario', ['id' => $usuario->id]) }}" method="post">
                {{ csrf_field() }}
                
                <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600; border-width: 4px;" class="black">
                <legend class="yellow accent-4">Alterar Permissão de Usuário</legend>
  
                <div class="row">
                    <div class="col s12 m12 l12 yellow-text text-accent-4">
                        <i class="material-icons yellow-text text-accent-4 prefix">loyalty</i>
                        {{ $usuario->name }}
                    </div>
                    @foreach ($permissoes as $perm)
                    <p class="col s12 m12 l12">
                        <input type="checkbox" id="{{ $perm->id }}" name="{{ $perm->cod_funcao }}"
                        @foreach ($permissoes_usuario as $pu) @if ($pu->id == $perm->id) checked="checked" @endif @endforeach/>
                        <label for="{{ $perm->id }}">{{ $perm->funcao }}</label>
                    </p>
                    @endforeach
                </div>
                </fieldset>
                <br>
                <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit">Alterar Permissão do Usuário
                    <i class="material-icons right black-text">send</i>
                </button>
            </form>
        </div>
        @endif

@endsection

@section('rodape')
    @if(isset($usuariosexception))
        @include('erp.partials.msgexception', ['exception' => $usuariosexception])
    @endif

    @if(isset($upusuarioexception))
        @include('erp.partials.msgexception', ['exception' => $upusuarioexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    
    @if(is_null($usuario))
        <script type="text/javascript">
            msgtela('sem cadastro de usuarios');
        </script>
    @endif
    
    @if(isset($upusuario))
        @if(!is_numeric($upusuario))
        <script type="text/javascript">
            msgtela('Permissão do usuário alterada');
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