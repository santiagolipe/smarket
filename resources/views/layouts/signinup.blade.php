<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !empty($title) ? ($title . ' - ' . config('app.name', 'Laravel')) : config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}" type="image/png">

    @include('includes.fonts')

    @include('includes.styles')
    <style media="screen">
        * {
            font-family: 'Varela Round', sans-serif;
        }
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Varela Round', sans-serif;
            font-weight: 100;
            min-height: 100vh;
            height: auto;
            margin: 0;
        }
        body {
            background-image: url('{{ asset('/img/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .panel,
        .button {
            -moz-transition:opacity 1s ease-in-out;
            -webkit-transition:opacity 1s ease-in-out;
            -ms-transition:opacity 1s ease-in-out;
            transition:opacity 1s ease-in-out;
            opacity:1;
        }

        .button {
            -moz-transition-delay: .5s;
            -webkit-transition-delay: .5s;
            -ms-transition-delay: .5s;
            transition-delay: .5s;
        }

        body.is-loading .button,
        body.is-loading .panel  {
            opacity: 0;
        }

        a.button {
            margin-bottom: 30px;
            text-decoration: none;
            font-size: 30px;
            text-transform: uppercase;
            padding: 10px 0;
            padding-right: 50px;
            bottom: 0;
        }

        .button::before {
            background-color: #FECE00;
            border-radius: 100%;
            padding: 20px;
            margin-right: 25px;
            color: black;
            filter: drop-shadow(0px 0px 10px rgba(0,0,0,.5));
            -webkit-filter: drop-shadow(0px 0px 10px rgba(0,0,0,.5));
            font-style: normal;
        }

        .button, .button:hover, .button:focus {
            background-color: #020852;
            color: white;
            border-radius: 50px;
            font-style: italic;
            cursor: pointer;
        }

        .button:hover {
            filter: opacity(.9);
        }

        button.button {
            padding: 5px 50px;
            font-size: 20px;
        }

        .iconbutton.back {
            padding: 0 0 15px 15px;
        }

        /* desktop */
        @media (min-width:992px) {
            .text-md-right {
                text-align: right;
            }
        }

        @media (max-width:991px) {
            .no-p * {
                padding-left: 0;
                padding-right: 0;
            }
        }

        @media (max-height:414px) {
            a.button b {
                padding-left: 0;
            }
        }

        .signinupcontent {
            min-height: calc(100% - 215px);
        }
    </style>
    @include('includes.scripts')
</head>
<body>
    <script>window.document.body.classList.add('is-loading');</script>
    <div id="app">
        <mynav class="small center" img="{{ asset('/img/logo.png') }}" alt="Smarket"></mynav>
        <div class="signinupcontent">
            @yield('content')
        </div>
        <iconbutton class="back" icon="fas fa-reply" href="{{route('index')}}">Voltar</iconbutton>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
