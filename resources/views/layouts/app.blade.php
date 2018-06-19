<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Physipal') }}</title>

    <!-- Styles -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dev.css') }}" rel="stylesheet">
    <link href="{{ asset('css/screen.css') }}" rel="stylesheet">
</head>
<body>
    <div class="grid-container">
        <div class="left">
                <nav>
                            @guest
                                <a href="{{ route('login') }}">Login</a>
                                <a href="{{ route('register') }}">Register</a>
                            @else
                            @yield('navbar')
                            @endguest
                </nav>

                <div class="footer">
                    <a href="https://www.instagram.com/physipal/"><img src="../img/instagram.svg" alt="icon instagram"/></a>
                    <a href="https://twitter.com/Physipal1"><img src="../img/twitter.svg" alt="icon twitter"/></a>
                    <a href="https://www.facebook.com/PhysipalBE/"><img src="../img/facebook.svg" alt="icon facebook"/></a>
                </div>
        </div>
    @yield('content')
    @yield('side')
</div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
