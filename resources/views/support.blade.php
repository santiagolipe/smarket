@extends('layouts.master', ['title' => 'Suporte'])

@section('styles')
    <style media="print">
        a[href]:after {
            content: none !important;
        }
        .panel {
            overflow-y: visible !important;
            text-align: justify;
        }
        .btn-print {
            display: none !important;
        }
    </style>
    <style>
        .btn-print {
            margin-bottom: 15px;
        }
        .panel {
            overflow-y: auto;
            height: calc(100vh - 230px);
            min-height: calc(100vh - 230px);
            resize: vertical;
            margin-bottom: 15px
        }
    </style>
@endsection

@section('content')
<mynav class="small center" img="{{ asset('/img/logo.png') }}" alt="Smarket" href="{{ route('index') }}"></mynav>
        <div class="container">
            <div class="panel col-md-12 col-xs-12" readonly>
                <h1>Suporte</h1>

                <p>Na tela inicial você consegue acessar o menu do sistema.</p>

                @if (Auth::user()->type == App\Lojista::type)
                    <ul>
                        <li><b><i class="fas fa-user"></i> Minha Conta:</b> Você consegue visualizar e atualizar seus dados, desconectar sua conta ou até mesmo excluí-la permanentemente (caso não tenha nenhum produto cadastrado e nenhuma venda realizada nesse supermercado).</li>
                        <li><b><i class="fas fa-cart-plus"></i> Cadastrar Produto:</b> Para cadastrar novos produtos de seu supermercado, acesse esse menu.</li>
                        <li><b><i class="fas fa-clipboard-list"></i> Lista de Produtos:</b> Nesse menu você consegue visualizar todos os produtos cadastrados em seu supermercado e também editar, excluir ou restaurar os produtos.</li>
                        <li><b><i class="fas fa-file-alt"></i> Relatório de Vendas:</b> Se você desejar, pode visualizar as vendas realizadas em seu supermercado acessando esse menu.</li>
                    </ul>
                @else
                    <ul>
                        <li><b><i class="fas fa-search"></i> Buscar Supermercados:</b> Para encontrar os supermercados de sua preferência, acesse esse menu.</li>
                        <li><b><i class="fas fa-shopping-basket"></i> Minhas Compras:</b> Nesse menu você consegue visualizar todas as compras que você já realizou.</li>
                        <li><b><i class="fas fa-user"></i> Meu Cadastro:</b> Você consegue visualizar e atualizar seus dados, desconectar sua conta ou até mesmo excluí-la permanentemente (caso não tenha realizado nenhuma compra).</li>
                        <li><b><i class="fas fa-shopping-bag"></i> Checkout:</b> Acessando esse menu você consegue visualizar os itens no carrinho e finalizar a sua compra.</li>
                    </ul>
                @endif

                <p><i>Caso tenha alguma dúvida ou algum problema, envie um email para <a href="mailto:smarket.app@hotmail.com">smarket.app@hotmail.com</a>.</i></p>
            </div>
            <iconbutton class="btn-print" icon="fas fa-print" onclick="javascript:window.print()">IMPRIMIR</iconbutton>
        </div>
@endsection
