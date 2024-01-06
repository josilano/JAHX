@extends('erp.template.templateerp')

@section('title', 'JahX Edita Registro de Caixa')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="amber-text text-accent-4 center-align">EDITAR REGISTRO DE CAIXA</h3>
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
        <a href="{{ route('jahx.criarregistro') }}" class="amber-text text-accent-4 valign-wrapper">
            <i class="material-icons left-align">chevron_left</i>
            <i class="fa fa-book teal-text" aria-hidden="true"></i>
            REGISTRO DE CAIXA
        </a>
    </div>
    <br><br>
    @if(isset($caixa))
        <div class="col l12 m12 s12">
            <form id="form-update-caixa" action="{{ route('jahx.atualizaregistro', ['id' => $caixa->id]) }}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                
                <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600; border-width: 4px;" class="black">
                <legend class="amber accent-4">Editar Registro de Caixa</legend>

                <div class="row">
                    <div class="col l4 m4 s12">
                        <p class="amber-text text-accent-4">
                            <i class="material-icons amber-text text-darken-3 prefix">done_all</i>
                            {{ $caixa->operacao }}
                        </p>
                    </div>

                    <div class="input-field col s12 m4 l4 amber-text text-accent-4">
                        <i class="material-icons amber-text text-darken-3 prefix">attach_money</i>
                        <input type="tel" required="required" maxlength="12" id="valor" name="valor"
                                onKeyUp="maskIt(this,event,'###.###.###,##',true)"
                                value="{{ number_format($caixa->valor, 2, ',', '.') }}">
                        <label for="valor">Valor</label>
                    </div>
                    <div class="input-field col l4 m4 s12 amber-text text-accent-4">
                        <i class="material-icons amber-text text-accent-4 prefix">event</i>
                        <input type="text" class="datepicker" name="data-pagamento-regcaixa" id="data-pagamento-regcaixa" value="{{ strftime('%d/%m/%Y', strtotime($caixa->data_pagamento)) }}">
                        <label for="data-pagamento-regcaixa">Data do pagamento</label>
                    </div>
                    <div class="input-field col s12 m12 l12 amber-text text-accent-4">
                        <i class="material-icons amber-text text-accent-4 prefix">description</i>
                        <input required type="text" id="descricao" name="descricao" maxlength="100" 
                        data-length="100" value="{{ $caixa->descricao }}">
                        <label for="descricao">Descrição</label>
                    </div>
                    @if ($caixa->operacao === 'Sangria')
                    <div class="input-field col s12 m12 l12 amber-text text-accent-4">
                        <i class="material-icons amber-text prefix">sentiment_dissatisfied</i>
                        <select id="custo" name="custo">
                        <option value="{{ $caixa->custo_fixo }}" selected>{{ $caixa->custo_fixo }}</option>
                        {{ $custos = CustoFacade::all() }}
                        @foreach ($custos as $custo)
                            <option value="{{ $custo->custo }}">{{ $custo->custo }}</option>
                        @endforeach
                        </select>
                        <label>Custo fixo/variável</label>
                    </div>
                    @endif
                    <div class="input-field col l6 m6 s6 amber-text text-accent-4">
                    <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                        <legend>Forma de Pagamento</legend>
                        <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
                        <?php $formapgs = FormaPagamentoFacade::all(); ?>
                        <select id="forma-pg" name="forma-pg">
                            <option value="{{ $caixa->forma_pg }}" selected>{{ $caixa->forma_pg }}</option>
                            @foreach($formapgs as $fpg)
                            <option value="{{ $fpg->forma }}">{{ $fpg->forma }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
                </div>
                </fieldset>
                <br>
                <button class="btn waves-effect waves-light yellow accent-4 black-text" type="submit">Atualizar Registro de Caixa
                    <i class="material-icons right black-text">send</i>
                </button>
            </form>
        </div>
        @endif

@endsection

@section('rodape')
    @if(isset($caixaexception))
        @include('erp.partials.msgexception', ['exception' => $caixaexception])
    @endif

    @if(isset($upcaixaexception))
        @include('erp.partials.msgexception', ['exception' => $upcaixaexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    @if(is_null($caixa))
        <script type="text/javascript">
            msgtela('Registro inexistente');
        </script>
    @endif
    
    @if(isset($upcaixa))
        @if(!is_numeric($upcaixa))
        <script type="text/javascript">
            msgtela('Registro de caixa atualizado');
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