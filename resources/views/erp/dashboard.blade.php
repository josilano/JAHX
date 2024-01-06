@extends('erp.template.templateerp')

@section('title', 'JahX')

@section('cabecalho')

@endsection

@section('navigation')
    @include('erp.partials.clienteerp')

    <div class="col l12 m12 s12 black">
        <h1 class="center-align white-text">Jah<span class="">X</span> ERP</h1>
    </div>
@endsection

@section('content')
    @if(session('msg'))
        <h1> {{ session('msg') }}</h1>
    @endif
    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahx.produtos') }}">
            <i class="medium material-icons indigo-text text-darken-4 waves-effect">shopping_basket</i>
        </a>
        <h6 class="purple-text text-darken-3">Produtos</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route ('jahx.clientes') }}">
            <i class="medium material-icons light-green-text text-accent-3 waves-effect">supervisor_account</i>
        </a>
        <h6 class="purple-text text-darken-3">Clientes</h6>
    </div>

    <div class="col s3 m3 l3 center-align">    
        <a href="{{ route('jahx.fornecedores') }}">
            <i class="medium material-icons orange-text text-accent-4 waves-effect">store</i>
        </a>
        <h6 class="purple-text text-darken-3">Fornecedor</h6>
    </div>

    <div class="col s3 m3 l3 center-align">    
        <a href="{{ route('jahx.ajustes') }}">
            <i class="medium material-icons purple-text waves-effect">settings</i>
        </a>
        <h6 class="purple-text text-darken-3">Ajustes</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahx.compras') }}">
            <i class="medium material-icons waves-effect">add_shopping_cart</i>
        </a>
        <h6 class="purple-text text-darken-3">Compras</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahx.vendas') }}">
            <i class="medium material-icons waves-effect">shopping_cart</i>
        </a>
        <h6 class="purple-text text-darken-3">Vendas</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahx.estoque') }}">
            <i class="medium material-icons waves-effect">assignment</i>
        </a>
        <h6 class="purple-text text-darken-3">Estoque</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahx.relatorios') }}">
            <i class="medium material-icons red-text waves-effect">picture_as_pdf</i>
        </a>
        <h6 class="purple-text text-darken-3">Relatorios</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahx.davs') }}">
            <i class="medium material-icons lime-text text-accent-2 waves-effect">receipt</i>
        </a>
        <h6 class="purple-text text-darken-3">Pré-venda</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahxpdv.inicial') }}">
            <i class="medium material-icons red-text waves-effect">important_devices</i>
        </a>
        <h6 class="purple-text text-darken-3">PDV WEB</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahx.apagar') }}">
            <i class="medium material-icons red-text waves-effect">trending_down</i>
        </a>
        <h6 class="purple-text text-darken-3">Contas a Pagar</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahx.areceber') }}">
            <i class="medium material-icons green-text waves-effect">trending_up</i>
        </a>
        <h6 class="purple-text text-darken-3">Contas a Receber</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahx.criarregistro') }}">
            <i class="fa fa-book fa-4x teal-text" aria-hidden="true"></i>
        </a>
        <h6 class="purple-text text-darken-3">Registro do Caixa</h6>
    </div>

    <div class="col s3 m3 l3 center-align">
        <a href="{{ route('jahx.balanco') }}">
        <i class="fa fa-balance-scale fa-4x purple-text" aria-hidden="true"></i>
        </a>
        <h6 class="purple-text text-darken-3">Balanço Mensal</h6>
    </div>

@endsection

@section('rodape')
    
@endsection