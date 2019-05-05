@extends('layouts.master')

@section('styles')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
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

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
                width: 100%;
                max-width: 100vw;
            }

            .title img {
                max-height: 150px;
            }

            .buttons {
                -moz-transition:opacity 3s ease-in-out;
                -webkit-transition:opacity 3s ease-in-out;
                -ms-transition:opacity 3s ease-in-out;
                transition:opacity 3s ease-in-out;
                opacity:1;
            }

            body.is-loading .buttons {
                opacity: 0;
            }

            .buttons .button {
                background-color: #020852;
                text-decoration: none;
                font-size: 40px;
                text-transform: uppercase;
                color: white;
                padding: 10px 0;
                padding-right: 50px;
                border-radius: 50px;
                font-style: italic;
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

            a.button {
                cursor: pointer;
            }

            /* desktop */
            @media (min-width:992px) {
                a.button:last-of-type {
                    margin-left: 10%;
                }
            }

            @media (max-width:991px) {
                .buttons .button {
                    font-size: 30px;
                }
            }

            @media (max-width:991px) and (min-height:415px) {
                .content {
                    transform: translateY(-40%);
                }
                .buttons {
                    position: absolute;
                    left: 50%;
                    transform: translateX(-50%);
                    padding: 0 30px;
                }
                .buttons .button {
                    font-size: 30px;
                }
                .buttons, .button {
                    width: 100%;
                }
                .button:last-of-type {
                    margin-top: 30px;
                }
                .button::before {
                    position: absolute;
                    top: inherit;
                    left: 30px;
                    transform: translateY(-27%);
                }
                .button b {
                    padding-left: 33%;
                }
            }

            /* tablet */
            @media (min-width:768px) and (max-width:991px) {
                .buttons {
                    padding: 0 150px;
                }
                .button::before {
                    left: 150px;
                    transform: translateY(-27%);
                }
                .button b {
                    padding-left: 15%;
                }
            }

            @media (max-height:414px) {
                a.button b {
                    padding-left: 0;
                }
            }

            .tippy-tooltip {
                font-size: 30px;
                font-weight: bold;
                padding: 10px 20px;
            }

            .tippy-tooltip ul {
                padding-left: 0;
                margin: 0;
                list-style: none;
            }

            .tippy-tooltip ul > li {
                display: inline-block;
            }

            a, a:hover {
                text-decoration: none;
                color: black;
            }

            .tippy-tooltip ul li:not(:first-child) {
                border-left: 1px solid #000;
                padding-left: 30px;
                margin-left: 30px;
            }

            .tippy-tooltip.smarket-theme {
                background-color: #FECE00;
                color: black;
            }

            .tippy-tooltip.smarket-theme[data-animatefill] {
                background-color: transparent;
            }

            .tippy-tooltip.smarket-theme .tippy-backdrop {
                background-color: #FECE00;
            }

            .tippy-tooltip.smarket-theme[x-placement^='top'] .tippy-arrow {
                border-top-color: #FECE00;
            }

            .tippy-tooltip.smarket-theme[x-placement^='bottom'] .tippy-arrow {
                border-bottom-color: #FECE00;
            }

            .tippy-tooltip.smarket-theme[x-placement^='left'] .tippy-arrow {
                border-left-color: #FECE00;
            }

            .tippy-tooltip.smarket-theme[x-placement^='right'] .tippy-arrow {
                border-right-color: #FECE00;
            }

            .tippy-tooltip.smarket-theme .tippy-roundarrow {
                fill: #FECE00;
            }
        </style>
@endsection

@section('scripts')
<script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/tippy.min.js') }}"></script>
@endsection

@section('content')
<div class="flex-center position-ref full-height">
            <div class="content">
                <mynav class="center" img="{{ asset('/img/logo.png') }}" alt="Smarket" href="{{ route('index') }}"></mynav>

                <div class="buttons">
                    <a href="{{ route('login') }}" class="button fas fa-sign-in-alt"><b>Entrar</b></a>
                    <a class="button register far fa-edit"><b>Registrar</b></a>
                </div>
            </div>
        </div>
@endsection

@section('body-scripts')
    <script>
            tippy('a.button.register', {
                ignoreAttributes: true,
                content: '<ul><li><a href="{{ route('register', ['type' => App\Cliente::type]) }}">Cliente</a></li><li><a href="{{ route('register', ['type' => App\Lojista::type]) }}">Lojista</a></li></ul>',
                trigger: 'click',
                placement: 'bottom',
                arrow: true,
                interactive: true,
                animation: 'scale',
                theme: 'smarket',
                distance: 20,
            });
        </script>
@endsection
