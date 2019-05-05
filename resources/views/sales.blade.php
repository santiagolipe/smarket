@extends('layouts.user', ['title' => 'Vendas'])

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

        [id^=orderitem_] {
            -webkit-transition: visibility 1s; /* Safari */
            transition: visibility 1s;
        }
        [id^=orderitem_] td {
            background-color: #EEEEEE !important;
            padding: 0 !important;
        }
        [id^=orderitem_] td div {
            padding: 8px 15px;
        }

        .orderitems label {
            text-align: right;
            min-height: 36px;
        }

        tbody.form-control {
            display: table-row-group;
        }
        tr.form-control {
            display: table-row;
        }
        tbody.items {
            color: #888888;
        }
        .table-wrapper {
            max-height: 185px;
            display: block;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0 0 15px 15px;
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

@section('scripts')
@parent
    <script>
        $(function() {
            $("a[id^=show_]").click(function(event) {
                var etarget = event.target || event.srcElement;
                var target = $("#orderitem_" + $(this).attr('id').substr(5));
                etarget.innerText = etarget.innerText == 'Detalhes' ? 'Ocultar' : 'Detalhes';
                target.css('visibility', target.css('visibility') == 'collapse' ? 'visible' : 'collapse');
                target.find('td > div').slideToggle();
                event.preventDefault();
            });
        });
    </script>
@stop

@section('usercontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <panel title="Vendas" body-class="no-p">
                    <div class="table-responsive col-md-12 m-0">
                        <table class="table orders mb-0 text-center">
                            <thead>
                                <th class="text-center min">COD</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center min">Entregar</th>
                                <th class="text-center min">Total</th>
                                <th class="text-center min">Data</th>
                                <th class="text-center min"></th>
                                <th class="text-center min"></th>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="min">{{ $order->id }}</td>
                                        @php
                                            $user = $order->user();
                                        @endphp
                                        <td>{{ 'COD.: ' . $user->id . ' - ' . $user->name . ' ' . $user->extra->surname }}</td>
                                        <td class="min">{{ 'pickup' === $order->delivery ? 'Não' : 'Sim' }}</td>
                                        <td class="min">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                                        <td class="min">{{ date_format($order->created_at, 'd/m/Y H:i') }}</td>
                                        <td class="min"><a id="show_{{ $order->id }}" href="javascript:;">Detalhes</a></td>
                                        <td class="min"><a href="{{ route('order.print', $order->id) }}" target="_blank">Imprimir</a></td>
                                    </tr>
                                    <tr id="orderitem_{{ $order->id }}" style="visibility: collapse;padding: 0;">
                                        <td class="orderitems" colspan="7">
                                            <div style="display: none;">
                                                <div class="form-horizontal col-md-6">
                                                    <div class="form-group col-md-12 col-sm-12">
                                                        <label for="weight" class="col-md-3 col-sm-3 p-xs-0 control-label">Endereço</label>

                                                        <div class="col-md-9 col-sm-9 p-xs-0" style="padding: 0;">
                                                            <input id="weight" type="text" class="form-control" value="{{ $order->address . ', ' . $order->number . ' - ' . $order->district }}" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-12 col-sm-12">
                                                        <label for="brand" class="col-md-3 col-sm-3 p-xs-0 control-label">Forma de Pagamento</label>

                                                        <div class="col-md-9 col-sm-9 p-xs-0" style="padding: 0;">
                                                            <input id="brand" type="text" class="form-control" value="{{ $order->payment }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12" style="padding: 0 !important;">
                                                    <div class="table-wrapper">
                                                        <table class="col-md-12 col-xs-12">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-left">Produto</th>
                                                                    <th class="text-right">Qtd.</th>
                                                                    <th class="text-right">Preço</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="form-control items">
                                                                @foreach ($order->items()->get() as $item)
                                                                <tr>
                                                                    <td class="text-left">{{ 'COD.: ' . $item->id . ' - ' . $item->product()->name }}</td>
                                                                    <td class="text-right">{{ $item->qty }}</td>
                                                                    <td class="text-right">{{ 'R$ '. number_format($item->price, 2, ',', '.') }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <table class="col-md-12 col-xs-12">
                                                            <thead>
                                                                <tr>
                                                                    <th>Subtotal</th>
                                                                    <th></th>
                                                                    <th class="text-right">{{ 'R$ '. number_format($order->subtotal, 2, ',', '.') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="form-control">
                                                                    <td class="min">Valor da entrega</td>
                                                                    <td class="text-right" colspan="2">{{ 'R$ '. number_format($order->delivery_fee, 2, ',', '.') }}</td>
                                                                </tr>
                                                                <tr class="form-control">
                                                                    <th>Total a pagar</th>
                                                                    <th class="text-right" colspan="2">{{ 'R$ '. number_format($order->total, 2, ',', '.') }}</th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($paginator->isEmpty())
                                    <tr><td colspan="7"><h1>Nenhuma venda foi realizada</h1></td></tr>
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
            </div>
        </div>
    </div>
@endsection
