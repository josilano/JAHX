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
@endsection

@section('rodape')
    
@endsection