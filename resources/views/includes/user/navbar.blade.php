@section('styles')
@parent
<style>
        button.button {
            vertical-align:top;
            border: none;
            white-space: normal;
            cursor: pointer;
            text-align: center;
            margin-right: 0.65rem;
            min-width: 200px;
            max-width: 200px;
            min-height: 45px;
            text-transform: none;
            line-height: 18px;
            font-weight: 400;
            font-size: 18px !important;
            display: inline-block;
            align-items: center;
            justify-content: center;
            top: 0px;
            padding: 0 10px 0 25px !important;
        }
        button.button i::before {
            background-color: #FECE00;
            border-radius: 100%;
            padding: 20px;
            margin-right: 25px;
            color: black;
            filter: drop-shadow(0px 0px 10px rgba(0,0,0,.5));
            -webkit-filter: drop-shadow(0px 0px 10px rgba(0,0,0,.5));
            font-style: normal;
            position: fixed;
            top: auto;
            left: inherit;
            transform: translate(-60px, -27px);
        }

        @media (max-width: 1299px) {
            .mynav .items {
                display: inline-block !important;
                width: 100%;
                padding-right: 0 !important;
            }

            .mynav .iconbutton {
                width: 100%;
                margin-right: 0 !important;
            }

            .mynav .iconbutton a {
                width: 100%;
                max-width: 100%;
            }
        }
        .right a {
            width: 55px;
            height: 55px;
            line-height: 55px;
            background-color: #FECE00;
            border-radius: 100%;
            text-align: center;
            color: black;
            text-decoration: none;
            font-size: 35px;
            filter: drop-shadow(0px 0px 10px rgba(0,0,0,.5));
            -webkit-filter: drop-shadow(0px 0px 10px rgba(0,0,0,.5));
        }
        .right a .circle {
            position: absolute;
            top: -10px;
            right: 0px;
            font-style: normal;
        }

        .right a .circle::after {
            text-align: center;
            display: block;
            border-radius: 100%;
            background-color: black;
            font-size: 20px;
            color: white;
            width: 25px;
            height: 25px;
            line-height: 25px;
            content: "{{ session()->has('cart') ? count(session()->get('cart')['items']) : 0 }}"
        }

        .right a.delivery {
            font-size: 25px;
        }

        .mynav .right a:hover {
            opacity: 0.8;
        }
    </style>
@stop

@if (Auth::user()->type == App\Lojista::type)
    <mynav class="small" img="{{ asset('img/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" href="{{ route('home') }}">
        <iconbutton icon="fas fa-user" href="{{ route('my-account') }}">Minha Conta</iconbutton>
        <iconbutton icon="fas fa-cart-plus" href="{{ route('product') }}">Cadastrar Produto</iconbutton>
        <iconbutton icon="fas fa-clipboard-list" href="{{ route('products.list') }}">Lista de Produtos</iconbutton>
        <iconbutton icon="fas fa-file-alt" href="{{ route('sales.list') }}">Relatório de Vendas</iconbutton>
        <a slot="right" class="delivery fas fa-truck" href="{{ route('deliveryfee.list') }}" title="Dados de Entrega"></a>
    </mynav>
@else
    <mynav class="small" img="{{ asset('img/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" href="{{ route('home') }}">
        <iconbutton icon="fas fa-search" href="{{ route('users.lojista.list') }}">Buscar Supermercados</iconbutton>
        <iconbutton icon="fas fa-shopping-basket" href="{{ route('orders.list') }}">Minhas Compras</iconbutton>
        <iconbutton icon="fas fa-user" href="{{ route('my-account') }}">Meu Cadastro</iconbutton>
        <a slot="right" class="fas fa-shopping-bag" href="{{ route('checkout') }}" title="Checkout"><i class="circle"></i></a>
    </mynav>
@endif
