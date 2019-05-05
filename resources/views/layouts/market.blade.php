@extends('layouts.user', ['back' => $back, 'title' => !empty($title) ? $title : NULL])

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
            padding-top: 15px;
            padding-bottom: 15px;
        }
        div.market .header {
            padding: 10px 0;
        }
        div.market > .logo {
            height: auto;
        }
        div.market > .logo[class*="col-xs-"] {
            padding-bottom: 33.33333333%;
        }
        @media (min-width: 768px) {
            div.market > .logo[class*="col-sm-"] {
                padding-bottom: 33.33333333%;
            }
            div.market .header {
                padding: 10px 0;
                position: absolute;
                bottom: 50px;
                right: 0;
            }
        }
        @media (min-width: 992px) {
            div.market > .logo[class*="col-md-"] {
                padding-bottom: 33.33333333%;
            }
        }
        @media (min-width: 1200px) {
            div.market > .logo[class*="col-lg-"] {
                padding-bottom: 16.66666667%;
            }
        }

        div.market > .logo img {
            display: inline-block;
            width: 100%;
            height: calc(100% - 5px);
            position: absolute;
            top: 0;
            left: 0;
        }
        div.market > .logo img {
            object-fit: fill;
            background-color: white;
            border: 8px solid #CCCCCC;
        }

        div.products {
            max-height: 330px;
            padding: 10px !important;
            border: 1px solid lightgray;
            background-color: #E6E6E6;
            overflow-y: auto;
        }

        div.products > .product {
            height: auto;
            padding: 5px;
            position: relative;
            display: inline-block;
        }
        div.products > .product a {
            height: calc(100% - 5px);
        }

        div.products > .product .name,
        div.products > .product .price {
            border: 1px solid lightgray;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 22px;
            overflow: hidden;
            height: 1.5em;
        }
        div.products > .product .name {
            background: white;
        }

        div.products > .product .price {
            background-color: #020852;
            color: #FECE00;
        }


        div.products > .product a img {
            object-fit: fill;
            background-color: white;
            border: 1px solid lightgray;
        }

        .departs-content {
            border: 1px solid gray;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .departs-content button {
            height: 33px;
            width: 22px;
            border: 0;
            background-color: white;
        }

        .departs-content button:first-child {
            float: left;
            border-right: 1px solid gray;
        }

        .departs-content button:last-child {
            float: right;
            border-left: 1px solid gray;
        }

        .departs-content ul {
            padding: 0;
            margin: 0;
            width: calc(100% - 44px);
            overflow-x: scroll;
            overflow-y: hidden;
            position: absolute;
            list-style: none;
            display: inline-flex;
            flex-flow: nowrap;
        }

        .departs-content ul li {
            display: flex;
            background-color: #E6E6E6;
            border-right: 1px solid gray;
            text-align: center;
            /* min-width: 133px; */
        }
        .departs-content ul li a {
            padding: 10px 30px;
            line-height: 14px;
        }
        .departs-content ul li.active {
            background-color: #CCCCCC;
        }
        .departs-content ul li a,
        .departs-content ul li a:hover {
            text-decoration: none;
            color: inherit;
        }

        @media (max-width: 991px) {
            .departs {
                width: calc(100vw - 1.3%);
                left: 50%;
                transform: translateX(-50%);
            }
        }

        select#order {
            background-color: transparent;
            border: 0;
            font-size: 18px;
        }

        .delivery a {
            float: right;
            width: 65px;
            height: 65px;
            background-color: white;
            border-radius: 100%;
            text-align: center;
            color: black;
            text-decoration: none;
            font-size: 20px;
        }

        @php
        $time = 0;
        if (session()->has('cart')) {
            $time = session()->get('cart')['delivery']['time'];
        } else {
            $deliveryfee = App\DeliveryFee::where('user', $market->id)->where('localization', App\Utils::normalize(Auth::user()->extra->district))->get()->first();
            if ($deliveryfee) {
                $time = $deliveryfee->time;
            }
        }
        @endphp
        .delivery a .time::after {
            text-align: center;
            display: inline-block;
            font-size: 15px;
            color: black;
            line-height: 5px;
            width: 100%;
            content: "{{ $time }} min"
        }
        .delivery a::before {
            line-height: 2.3;
        }
        .delivery a i {
            display: flex;
        }



        .form-group label {
            text-align: right;
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

        @media (min-width: 992px) {
            .delivery a {
                line-height: 35px;
                position: absolute;
                top: 0;
                right: 0;
            }
            .delivery a .time {
                font-style: normal;
                position: absolute;
                top: 22px;
                right: 0;
                width: 100%;
            }
            .delivery a .time::after {
                line-height: 2.8;
            }
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
            div.departs {
                position: absolute;
                bottom: 5px;
                right: 0;
            }
        }

        @media (max-width: 1299px) {
            #app > .container {
                margin-top: 20px;
            }
        }
    </style>
@stop

@section('scripts')
@parent
    <script type="text/javascript">
        function scrollToLeft(id, d) {
            var el = document.getElementById(id);
            if (el.scrollLeft > 0) {
                el.scrollLeft -= d;
            }
        }

        function scrollToRight(id, d) {
            var el = document.getElementById(id);
            if(el.scrollLeft < (el.scrollWidth - el.clientWidth)) {
                el.scrollLeft += d;
            }
        }

        $(window).resize(function() {
        	$('div.products > .product img').height($('div.products > .product img').width());
        });
        $(window).ready(function() {
        	$('div.products > .product img').height($('div.products > .product img').width());
            $('#departs-items:empty').hide();
        });
    </script>
@stop

@section('usercontent')
    <div class="container-fluid">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 pr-0 market">
            <div class="logo col-lg-2 col-md-4 col-sm-4 col-xs-4">
                <img class="img" title="{{ $market->name }}" width="100%" height="100%" src="{{ asset($market->extra->logo ? $market->extra->logo : 'img/logo-market.jpg') }}" alt="">
            </div>

            <h1 class="col-lg-10 col-md-8 col-sm-8 col-xs-8" style="color: black;font-weight: bold;font-size: 200%;margin: 10px 0;">Supermercado {{ $market->name }}</h1>
            <p class="h6 col-lg-10 col-md-8 col-sm-8 col-xs-8">{{ $market->extra->desc }}</p>

            <div class="delivery">
                <a class="fas fa-truck"><i class="time"></i></a>
            </div>

            <div class="col-lg-10 col-md-8 col-sm-8 col-xs-12 header">
                <form class="form-search col-md-12 pr-0" method="GET" action="{{ route('users.lojista.items', $market) }}" >
                    <div class="col-lg-9 col-md-8 col-sm-6 text-right" style="line-height: 36px">
                        <select id="order" name="order" onchange="this.form.submit()">
                            <option value="" selected disabled hidden>Ordernar Produtos</option>
                            <option value="name+asc" {{ 'name+asc' === app('request')->input('order') ? ' selected' : '' }}>Nome (Crescente)</option>
                            <option value="name+desc" {{ 'name+desc' === app('request')->input('order') ? ' selected' : '' }}>Nome (Decrescente)</option>
                            <option value="price+asc" {{ 'price+asc' === app('request')->input('order') ? ' selected' : '' }}>Preço (Crescente)</option>
                            <option value="price+desc" {{ 'price+desc' === app('request')->input('order') ? ' selected' : '' }}>Preço (Decrescente)</option>
                        </select>
                    </div>

                    <input type="hidden" name="dept" value="{{ !empty($dept) ? $dept : '' }}">
                    <div class="input-group col-lg-3 col-md-4 col-sm-6">
                        <input type="text" class="form-control" placeholder="Procurar Produtos" name="search" value="{{ request('search') }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-search">
                                <span class="fas fa-search"></span>
                            </button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="departs col-lg-10 col-md-8 col-sm-6 col-xs-12 p-sm-xs-0 pr-0">
                <div id="departs" class="departs-content">
                    <button type="button" class="fas fa-caret-left" name="button" onmousedown="scrollToLeft('departs-items', 50)" style="float:left"></button>
                    <ul id="departs-items">
                        @foreach ($depts as $department)
                            <li{{ $dept === $department->dept ? ' class=active' : '' }}><a href="{{ route('users.lojista.items', ['id' => $market->id, 'dept' => $department->dept]) }}">{{ $department->dept }}</a></li>
                        @endforeach
                    </ul>
                    <button type="button" class="fas fa-caret-right" name="button" onmousedown="scrollToRight('departs-items', 50)" style="float:right"></button>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 products">
            @yield('marketcontent')
        </div>
    </div>
@endsection
