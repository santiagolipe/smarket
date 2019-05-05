@extends('layouts.master', ['title' => !empty($title) ? $title : NULL])

@section('styles')
@parent
    <style>
        .usercontent {
            min-height: calc(100% - 236px);
        }
        @media (min-width: 1300px) {
            .usercontent {
                min-height: calc(100% - 215px);
            }
        }
        .buttons-bottom {
            display: inline-block;
            width: 100%;
        }
        .buttons-bottom .iconbutton {
            margin: 0 !important;
        }
        .mynav .iconbutton a {
            min-width: 100%;
        }
        @media (min-width: 745px) {
            #logout {
                float: right;
            }
            #logout .iconbutton {
                padding: 0 0 15px 0;
            }
        }

        @if (request()->path() == 'home')
        #logout .iconbutton a {
            margin: 0;
        }
        @media (min-width: 745px) {
            #logout .iconbutton {
                padding: 0 15px 15px 0;
            }
        }
        @else
        @media (min-width: 745px) {
            .iconbutton.back {
                padding: 0 0 15px 15px;
            }
            .iconbutton.support {
                float: right;
                padding: 0 15px 15px 0;
                padding-left: 40px;
            }
        }
        .iconbutton.support.hasicon i {
            background-color: #4C6A85;
            color: white;
            left: 10px;
            width: 30px;
            height: 30px;
            font-size: 20px;
            line-height: 30px;
            filter: none;
        }
        .iconbutton.support a {
            border: 3px solid #a94442;
            font-weight: bold;
        }
        .iconbutton.support a:not(:hover) {
            background-color: transparent;
            color: white;
        }
        .iconbutton.support a:hover {
            background-color: #a94442;
        }
        @endif
        @media (max-width: 744px) {
            #logout {
                width: 100%;
            }
            .buttons-bottom .iconbutton {
                padding: 0 15px 15px;
                width: 100%;
            }
            .buttons-bottom .iconbutton a {
                max-width: none;
            }
        }
    </style>
@stop

@section('content')
    @include('includes.user.navbar')
    <div class="usercontent">
        @yield('usercontent')
    </div>
    <div class="buttons-bottom">
        @if (request()->path() !== 'home')
            <iconbutton class="back" icon="fas fa-reply" href="{{empty($back) ? route('home') : $back}}">VOLTAR</iconbutton>
            <iconbutton class="support" icon="fas fa-question" href="{{ route('support') }}" target="_blank">SUPORTE</iconbutton>
        @endif
        <form id="logout" action="{{ route('logout') }}" method="POST">
            {{ csrf_field() }}
            <iconbutton icon="fas fa-sign-out-alt">SAIR</iconbutton>
        </form>
    </div>
@endsection
