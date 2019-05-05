    <!-- Styles -->
    <meta name="theme-color" content="#020852">
    <meta name="msapplication-navbutton-color" content="#020852">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        * {
            font-family: 'Varela Round', sans-serif;
        }
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Varela Round', sans-serif;
            font-weight: 100;
            margin: 0;
        }
        html, body, #app {
            min-height: fit-content;
            height: 100vh;
        }
        body {
            background-image: url('{{ asset('/img/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .no-p, .no-p>*,
        .no-p .form-group {
            padding: 0 !important;
        }

        .no-in-p>*,
        .no-in-p .form-group {
            padding: 0 !important;
        }

        .no-m-t, .no-m-t>* {
            margin-top: 0;
        }
    </style>
    @yield('styles')
