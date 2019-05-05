@extends('layouts.user', ['title' => 'Buscar Supermercados'])

@section('styles')
@parent
    <style>
        .usercontent, .buttons-bottom {
            background-color: #E6E6E6;
        }
        .iconbutton.support a:not(:hover) {
            background-color: transparent;
            color: #a94442;
        }
        .container-fluid {
            padding-bottom: 15px;
        }
        .container-fluid .header {
            padding: 10px 0;
        }
        .form-search {
            padding: 0;
        }
        div.markets {
            display: inline-flex;
            flex-flow: wrap;
            max-height: calc(100vh - 378px);
            padding: 10px !important;
            border: 1px solid lightgray;
            background-color: #E6E6E6;
            overflow-y: auto;
        }

        div.markets > .market {
            height: auto;
        }
        div.markets > .market[class*="col-xs-"] {
            padding-bottom: 100%;
        }
        @media (min-width: 768px) {
            div.markets > .market[class*="col-sm-"] {
                padding-bottom: 50%;
            }
        }
        @media (min-width: 992px) {
            div.markets > .market[class*="col-md-"] {
                padding-bottom: 33.33333333%;
            }
        }
        @media (min-width: 1200px) {
            div.markets > .market[class*="col-lg-"] {
                padding-bottom: 16.66666667%;
            }
        }
        div.markets > .market a {
            position: absolute;
            top: 0;
            left: 0;
            display: inline-block;
            height: calc(100% - 5px);
            width: 100%;
            padding: 5px;
        }

        div.markets > .market a img {
            object-fit: fill;
            background-color: white;
            border: 1px solid lightgray;
        }

        .form-group label {
            text-align: right;
        }
        input:not([type="checkbox"]), textarea {
            width: 100%;
        }
        textarea {
            resize: vertical;
            min-height: 150px;
        }

        .col-md-1-33 ,
        .col-md-10-67 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        select#order {
            background-color: transparent;
            border: 0;
            font-size: 18px;
        }

        @media (min-width: 992px) {
            .col-md-1-33 ,
            .col-md-10-67 {
                float: left;
            }
            .col-md-1-33 {
                width: 11.11111111%;
            }
            .col-md-10-67 {
                width: 88.88888889%;
            }
            .col-md-offset-1-33 {
                margin-left: 11.11111111%;
            }
        }

        @media (max-width: 1299px) {
            #app > .container {
                margin-top: 20px;
            }
        }
    </style>
@stop

@section('usercontent')
    <div class="container-fluid">
        <h1 class="h1" style="color: black;font-weight: bold;margin: 10px 0;">BUSCAR SUPERMERCADOS</h1>
        <p>Ao encontrar o supermercado desejado, clique sobre a imagem para visualizar seus produtos.</p>
        <div class="col-md-12 header">
            <form class="form-search col-md-12" method="GET" action="{{ route('users.lojista.list') }}" >
                <div class="col-md-9 text-right" style="line-height: 36px">
                    <select id="order" name="order" onchange="this.form.submit()">
                        <option value="" selected disabled hidden>Ordernar Supermercados</option>
                        <option value="name+asc" {{ 'name+asc' === app('request')->input('order') ? ' selected' : '' }}>Nome (Crescente)</option>
                        <option value="name+desc" {{ 'name+desc' === app('request')->input('order') ? ' selected' : '' }}>Nome (Decrescente)</option>
                        <option value="lojistas.sales+desc" {{ 'lojistas.sales+desc' === app('request')->input('order') ? ' selected' : '' }}>Mais Venda</option>
                        <option value="lojistas.sales+asc" {{ 'lojistas.sales+asc' === app('request')->input('order') ? ' selected' : '' }}>Menos Venda</option>
                    </select>
                </div>
                <div class="input-group col-md-3">
                    <input type="text" class="form-control" placeholder="Procurar Supermercados" name="search" value="{{ request('search') }}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-search">
                            <span class="fas fa-search"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 markets">
            @foreach ($markets as $market)
                <div class="market col-lg-2 col-md-4 col-sm-6 col-xs-12">
                    <a title="{{ $market->name }}" href="{{ route('users.lojista.items', $market->id) }}">
                        <img class="img" width="100%" height="100%" src="{{ asset($market->extra->logo ? $market->extra->logo : 'img/logo-market.jpg') }}" alt="{{ $market->name }}">
                    </a>
                </div>
            @endforeach
            @if (empty($markets))
                <h1 class="text-center col-lg-12 col-md-12 col-sm-12 col-xs-12 m-0">Nenhum Supermercado</h1>
            @endif
        </div>
    </div>
@endsection
