<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Página Não Encontrada - {{ config('app.name', 'Laravel') }}</title>

        @include('includes.favicons')

        <!-- Fonts -->
        <link href="{{ asset('fonts/Raleway100-600-VarelaRound.css') }}" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Varela Round', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }

            .text-info {
                color: #17a2b8;
                text-decoration: none;
            }

            a.text-info:hover,
            a.text-info:focus {
                opacity: 0.8;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <img src="{{ asset('img/404.png') }}" alt="404">
                <div class="title">
                    Desculpe, a página que você está procurando não foi encontrada.
                </div>
                <a class="text-info" href="{{ route('index') }}">Ir para a página inicial</a>
            </div>
        </div>
    </body>
</html>
