@extends('erp.template.templateerp')

@section('title', 'Usuario')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h1 class="center-align white-text">Usuário</h1>
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

    <form id="form-update-myuser" action="{{ route('jahx.atualizameuusuario', ['id' => Auth::user()->id]) }}" method="post">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <input type="hidden" id="pessoa-id" name="pessoa-id" value="{ $pessoa_id }}">
        <fieldset style="border-radius: 20px; border-color: #ffd600;">
            <legend class="yellow-text text-accent-4">Meus dados</legend>
            <div class="row">
                <div class="col l12 m12 s12">
                    <label class="">Cargo </label>
                    <i class="material-icons yellow-text text-accent-4 prefix">work</i>
                    {{ Auth::user()->cargo }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                    <i class="material-icons yellow-text text-accent-4 prefix">account_circle</i>
                    <input required type="text" id="name" name="name" maxlength="60" data-length="60" value="{{ Auth::user()->name }}">
                    <label for="name">Nome</label>
                </div>

                <div class="input-field col s12 m12 l12 yellow-text text-accent-4">
                    <i class="material-icons yellow-text text-accent-4 prefix">email</i>
                    <input required type="email" id="email" name="email" maxlength="80" data-length="80" value="{{ Auth::user()->email }}">
                    <label for="email">E-Mail</label>
                </div>
            </div>
        </fieldset>
        <br>
        <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit" name="action">Atualizar meus dados
            <i class="material-icons right">send</i>
        </button>
    </form>

@endsection

@section('rodape')
    
@endsection

@section('script')
    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    @if(isset($aviso))
        <script type="text/javascript">
            msgtela("{{ $aviso }}");
        </script>
    @endif
@endsection