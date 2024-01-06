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
    <link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.min.css') }}" type="text/css">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">-->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    @yield('style')

</head>
<body class="grey lighten-4">

<!-- header principal -->
<!--<div class="" >
    <div class="row black">
        @yield('cabecalho')
    </div>
</div>-->

<!-- section cab main -->
<div class="">
    <div class="row">
        @yield('navigation')
    </div>
</div>

<div class="section white">
    <div class="container">
        <div class="row white">
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