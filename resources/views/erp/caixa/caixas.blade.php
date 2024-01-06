@extends('erp.template.templateerp')

@section('title', 'JahX Livro do Registro do Caixa')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h3 class="amber-text text-accent-4 center-align">REGISTRO DO CAIXA</h3>
        <table class="highlight amber-text text-accent-4 container">
            <thead>
                <tr>
                    <th>Tópico</th>
                    <th>QTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total de Registros Realizados</td>
                    <td>@if(isset($registros_caixa)){{ $registros_caixa->total() }}@endif</td>
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

    <ul class="collapsible" data-collapsible="accordion">
        <li>
            <div class="collapsible-header amber accent-4"><i class="material-icons">filter_drama</i>Cadastrar Registro do Caixa</div>
            <div class="collapsible-body black">
                <form id="form-create-registrocaixa" action="{{ route('jahx.addregistrocaixa') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}">

                <fieldset style="border-radius: 20px; border-color: #ffd600;">
                    <legend class="purple-text text-darken-3 amber-text text-accent-4">Dados do Registro</legend>
                    <div class="row">
                        <div class="input-field col s12 m12 l12 amber-text text-accent-4">
                            <i class="material-icons amber-text prefix">loyalty</i>
                            <select id="operacao" name="operacao" required>
                                <option value="Sangria" selected>Sangria</option>
                                <option value="Suprimento">Suprimento</option>
                            </select>
                            <label>Operação</label>
                        </div>
                        <div class="input-field col s12 m4 l4 amber-text text-accent-4">
                            <i class="material-icons amber-text text-darken-3 prefix">attach_money</i>
                            <input type="tel" required="required" maxlength="12" id="valor" name="valor"
                                onKeyUp="maskIt(this,event,'###.###.###,##',true)">
                            <label for="valor">Valor</label>
                        </div>
                        <div class="input-field col l4 m4 s12 offset-l2 amber-text text-accent-4">
                            <i class="material-icons amber-text text-accent-4 prefix">event</i>
                            <input type="text" class="datepicker" name="data-pagamento-regcaixa" id="data-pagamento-regcaixa" value="{{ strftime('%d/%m/%Y') }}">
                            <label for="data-pagamento-regcaixa">Data do pagamento</label>
                        </div>
                        <div class="input-field col s12 m12 l12 amber-text text-accent-4">
                            <i class="material-icons amber-text text-accent-4 prefix">label_outline</i>
                            <input required type="text" id="descricao" name="descricao" maxlength="100" data-length="100">
                            <label for="descricao">Descrição</label>
                        </div>
                        <div class="input-field col s12 m12 l12 amber-text text-accent-4">
                            <i class="material-icons amber-text prefix">sentiment_dissatisfied</i>
                            <select id="custo" name="custo">
                            <option value="Sem Custo" selected>Sem Custo</option>
                            {{ $custos = CustoFacade::all() }}
                            @foreach ($custos as $custo)
                                <option value="{{ $custo->custo }}">{{ $custo->custo }}</option>
                            @endforeach
                            </select>
                            <label>Custo fixo/variável</label>
                        </div>
                        <div class="input-field col l6 m6 s6 amber-text text-accent-4">
                            <fieldset style="border-radius: 20px; border-color: #ffd600;" class="valign-wrapper">
                                <legend>Forma de Pagamento</legend>
                                <i class="material-icons amber-text text-accent-4 prefix">monetization_on</i>
                                <?php $formapgs = FormaPagamentoFacade::all(); ?>
                                <select id="forma-pg" name="forma-pg">
                                    @foreach($formapgs as $fpg)
                                    <option value="{{ $fpg->forma }}" @if ($fpg->forma == 'DINHEIRO') selected @endif >{{ $fpg->forma }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </fieldset>
                <br>
                <button class="btn waves-effect waves-light amber accent-4 black-text" type="submit">Registrar Fluxo de Caixa
                    <i class="material-icons right black-text">send</i>
                </button>
                </form>

            </div>
        </li>
    </ul>
    <div class="row">
        <div class="input-field col l6 m6 s12">
            <input type="text" class="datepicker" name="data-regcaixa" id="data-regcaixa" onchange="permiteDataEnvio();">
            <label for="data-regcaixa">Data do Registro de caixa</label>
        </div>
        <div class="col l6 m6 s12">
            <div class="waves-effect waves-light btn amber accent-4 black-text right"
                    onclick="buscaRegCaixaPorData();" id="link-busca-data-venda" disabled>
                <i class="material-icons left black-text">calendar_today</i>Buscar por data
            </div>
        </div>
    </div>

    @if (isset($registros_caixa))
        @include ('erp.partials.caixas.componentelistaregcaixas')

        @include ('erp.partials.componentepaginacao', ['paginacao' => $registros_caixa])
    @endif
    
@endsection

@section('rodape')
    @if(isset($vendasexception))
        @include('erp.partials.msgexception', ['exception' => $vendasexception])
    @endif

    @if(isset($cadvendaexception))
        @include('erp.partials.msgexception', ['exception' => $cadvendaexception])
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function msgtela(testemsg){
            Materialize.toast(testemsg, 4000);
        }
    </script>
    @if(is_null($registros_caixa))
        <script type="text/javascript">
            msgtela('sem registros de caixa');
        </script>
    @endif
    
    @if(isset($cadregcaixa))
        @if(!is_numeric($cadregcaixa))
        <script type="text/javascript">
            msgtela('Registro cadastrado');
        </script>
        @endif
    @else
        <script type="text/javascript">
            msgtela('Erro no cadastro');
        </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function() {
            
        });

        function permiteDataEnvio(){
            if ($('#data-regcaixa').val() != '')
                $('#link-busca-data-venda').attr('disabled', false);
            else 
                $('#link-busca-data-venda').attr('disabled', true);
        }

        function buscaRegCaixaPorData(){
            var dia = $('#data-regcaixa').val().replace('/', '-').replace('/', '-');
            window.location.replace("/erp/registro-do-caixa/periodo/"+dia);
        }

        var caixa_id = null;
        function setCaixaIdToExcluir(id){
            caixa_id = id;
        }

        function excluirCaixa(){
            if (caixa_id == null) msgtela('Nao pode exlcuir registro sem identificacao');
            else {
                $.ajax({
                    url: "/erp/registro-do-caixa/"+caixa_id,
                    type: 'DELETE',
                    data: {"_token": "{{ csrf_token() }}" },
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        window.location.replace("/erp/registro-do-caixa");
                        //debugger;
                        msgtela('Registro do Caixa Excluído');
                        console.log(response);
                    },
                    error: function (response){
                        msgtela('Erro na Exclusão');
                        window.location.replace("/erp/registro-do-caixa");
                        console.log(response);
                    }
                    
                });
            }
        }
    </script>

    @if(session('msg'))
        <script type="text/javascript">
            $(document).ready(function(){
                $('#modal1').modal('open');
            });
        </script>
    @endif
@endsection