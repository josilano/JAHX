<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('metascript')
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/stylecid.css') }}" type="text/css">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">-->
    @yield('style')

</head>
<body>

<div class="">
    <div class="row black yellow-text">merda</div>
</div>

<div class="">
    <div class="row">
        <div class="col l7 m7 s7">@yield('contentpdv')</div>
        
        
        <div class="col l4 m4 s4">
            @yield('telapdv')
        </div>
    </div>
</div>

<div class="">
    <div class="row black">
        <div class="col l5 m5 s5"><span class="yellow-text text-accent-4 show-on-large">F7 - CANCELA ITEM | F8 - CANCELA VENDA | F9 - FINALIZAR VENDA</span>DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV DUPI PDV </div>
        <div class="col l2 m2 s12 center-align">
            <br><img src="{{ asset('img/dupi.logo.red.png') }}" alt="dupi" class="circle" width="80"></div>
        </div>
        <div class="col l5 m5 s5 white-text"></div>
</div>
<!-- header principal -->
<div class="container" >
    <div class="row">
        @yield('cabecalho')
    </div>
</div>

<!-- section cab main -->
<div class="container">
    <div class="row purple darken-3">
        @yield('navigation')
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            @yield('content')
        </div>
    </div>
</div>

<div class="footer">
    @yield('rodape')
</div>

<!-- JQuery -->
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.1.min.js"></script>
<!-- JavaScript -->
<script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/init.js') }}"></script>
@yield('script')

</body>
</html>