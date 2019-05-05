@extends('layouts.user', ['title' => 'Relatório de Vendas'])

@php
    $orders = $paginator->items();
@endphp

@section('styles')
@parent
    <style>
        table.orders a {
            cursor: pointer;
        }
        table.orders a:not([href]),
        table.orders a:not([href]):hover {
            color: inherit;
            cursor: default;
            text-decoration: none;
        }
        .table-responsive {
            overflow-y: auto;
            max-height: 100%;
        }
        .table-responsive .empty {
            border: 1px solid gray;
        }
        table.orders > tbody td {
            border: 1px solid gray;
        }
        table.orders > thead {
            background-color: gray;
            color: white;
        }
        table.orders > thead,
        table.orders > thead th {
            border: 1px solid black;
        }
        table.orders tbody {
            border-color: gray;
        }
        table.orders tbody td:first-child {
            background-color: lightgray;
        }
        table.orders .min {
            width: 1%;
            white-space: nowrap;
        }
        table.orders > thead th,
        table.orders > tbody td {
            padding-left: 15px;
            padding-right: 15px;
        }
        .pagination {
            display: inline-flex;
            overflow-x: auto;
            max-width: 60%;
        }
        .pagination > li > a,
        .pagination > li > span {
            color: #333333;
        }
        .pagination > li > a:hover,
        .pagination > li > a:focus,
        .pagination > li > span:hover,
        .pagination > li > span:focus {
            color: #636b6f;
        }
        .pagination > .active > a,
        .pagination > .active > a:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span,
        .pagination > .active > span:hover,
        .pagination > .active > span:focus {
            background-color: #020852;
            border-color: #020852;
        }
        .col-md-1-33 ,
        .col-md-10-67 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .iconbutton.hasicon.print {
            left: 50%;
            transform: translateX(-50%);
        }
        .iconbutton.hasicon.print i {
            background-color: white;
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
        <div class="row">
            <div class="col-md-12">
                <panel title="Relatório de Vendas" body-class="no-p">
                    <div class="table-responsive col-md-12 m-0">
                        <table class="table orders mb-0 text-center">
                            <thead>
                                <th class="text-center min">COD</th>
                                <th class="text-center">Produtos Vendidos</th>
                                <th class="text-center min">Marca</th>
                                <th class="text-center min">Quantidade de Vendas</th>
                                <th class="text-center min">Total de Vendas</th>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="min">{{ $order->id }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td class="min">{{ $order->brand }}</td>
                                        <td class="min">{{ $order->totalqty }}</td>
                                        <td class="min">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                @if ($paginator->isEmpty())
                                    <tr><td colspan="5"><h1>Nenhuma venda foi realizada</h1></td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($paginator->isNotEmpty())
                        <div slot="footer" class="text-center">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination m-0">
                                    <li class="page-item{{ 1 === $paginator->currentPage() ? ' disabled' : '' }}">
                                        <a class="page-link" aria-label="Anterior" tabindex="-1"{{ 1 !== $paginator->currentPage() ? ' href='.$paginator->previousPageUrl() : '' }}>
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="pagination justify-content-center m-0">
                                    @php
                                        $pages = $paginator->getUrlRange(1, $paginator->lastPage());
                                    @endphp
                                    @for ($i=1; $i <= $paginator->lastPage(); $i++)
                                        <li class="page-item{{ $paginator->currentPage() === $i ? ' active' : '' }}"><a class="page-link"{{ $paginator->currentPage() !== $i ? ' href='.$pages[$i] : '' }}>{{ $i }}</a></li>
                                    @endfor
                                </ul>
                                <ul class="pagination m-0">
                                    <li class="page-item{{ $paginator->lastPage() === $paginator->currentPage() ? ' disabled' : '' }}">
                                        <a class="page-link" aria-label="Próxima" tabindex="-1"{{ $paginator->lastPage() !== $paginator->currentPage() ? ' href='.$paginator->nextPageUrl() : '' }}>
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Próxima</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    @endif
                </panel>
                <iconbutton class="print" icon="fas fa-print" href="{{ route('sales.list.print') }}" target="_blank">Imprimir</iconbutton>
            </div>
        </div>
    </div>
@endsection
