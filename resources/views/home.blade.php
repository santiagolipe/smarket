@extends('layouts.user', ['title' => 'Início'])

@section('styles')
@parent
    <style>
        .welcome {
            background-color: white;
            border-radius: 4px;
            width: 100%;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
        }
    </style>
@stop

@section('usercontent')
    <div class="container-fluid welcome">
        <h1>Bem Vindo(a) {{ Auth::user()->name }}.</h1>

        <h3>Mantenha seus dados em dia.</h3>
        @if (Auth::user()->type == App\Lojista::type)
            <h4>Acesse o menu <a href="{{ route('my-account') }}">Minha Conta</a> para verificar e atualizar os seus dados.</h4>
            <h3>Lembre de acessar <a href="{{ route('product') }}">Cadastrar Produto</a> e cadastrar todos os seus produtos.</h3>
            <h3>Rejeva seus produtos já cadastrados em <a href="{{ route('products.list') }}">Lista de Produtos</a>.</h3>
            <h3>Em <a href="{{ route('sales.list') }}">Relatório de Vendas</a> você consegue ver todas as vendas realizadas em seu supermercado.</h3>

            <h2>Visualize as vendas realizadas em seu supermercado clicando <a href="{{ route('sales') }}">aqui</a>.</h2>
        @else
            <h4>Acesse o menu <a href="{{ route('my-account') }}">Meu Cadastro</a> para verificar e atualizar os seus dados.</h4>
            <h3>Em <a href="{{ route('users.lojista.list') }}">Buscar Supermercados</a> você consegue encontrar o seu supermercado ideal para realizar suas compras.</h3>
            <h3>Reveja suas compras já realizadas acessando o menu <a href="{{ route('orders.list') }}">Minhas Compras</a></h3>
        @endif
    </div>
@endsection
