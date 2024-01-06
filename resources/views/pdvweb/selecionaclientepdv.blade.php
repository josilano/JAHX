@extends('pdvweb.templatepdv.templatepdvweb')

@section('title', 'JahX PDV')

@section('contentpdv')
    @include('erp.partials.componenteautocomplete')

    @include('erp.partials.componentemostraumcliente')

    <div class="row">
        <div class="col l8 m8 s12">
            <h6>Produto selecionado</h6>
        </div>
    </div>
    
@endsection

@section('telapdv')
    <p>pdv aqui</p>
      
@endsection

@section('cabecalho')
    
@endsection

@section('navigation')

@endsection

@section('content')
    
@endsection

@section('rodape')
    
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#autocomplete-input').autocomplete({
            data: {
              @foreach($clientes as $cliente)
              "{{ $cliente->nome_rsocial }}": null,
              @endforeach
            },
            limit: 20,
            onAutocomplete: function(slug) {
                $.ajax({
                    url: "/erp/clientes/nome/"+slug,
                    type: 'GET',
                    //data: {slug},
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success: function (response) {
                        $('#pessoa_tipo').html(response.pessoa_tipo);
                        $('#nome_rsocial').html(response.nome_rsocial);
                        $('#cpf_cnpj').html(response.cpf_cnpj);
                        $('#nome_fantasia').html(response.nome_fantasia);
                        $('#email').html(response.email);
                        $('#logradouro').html(response.logradouro);
                        $('#numero').html(response.numero);
                        $('#complemento').html(response.complemento);
                        $('#bairro').html(response.bairro);
                        $('#cidade').html(response.cidade);
                        $('#estado').html(response.estado);
                        $('#cep').html(response.cep);
                        $('#tel_principal').html(response.tel_principal);
                        $('#tel_secundario').html(response.tel_secundario);
                        $('.linkeditarcliente').attr('href', '/erp/clientes/'+response.id);
                        $('input[type=hidden][name=id-cliente]').val(response.id);
                        $('#autocomplete-input').val('');
                        //debugger;
                        //console.log(slug);
                    }
                });
            },
            minLength: 1,
          });
        });        
    </script>
@endsection