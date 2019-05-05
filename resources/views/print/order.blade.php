<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Pedido #{{ $order->id }} - {{ config('app.name', 'Laravel') }}</title>
        <style>
            h1 {
                text-align: center;
            }
            table {
                width: 100%;
            }
            .text-center {
                text-align: center;
            }
            .text-right {
                text-align: right;
            }
            .col-6 {
                width: 50%;
            }
            .col-offset-6 {
                margin-left: 50%;
            }
        </style>
        <style media="print">
            button {
                display: none;
            }
        </style>
    </head>
    <body>
        <h1><b>{{ 'Pedido #' . $order->id }}</b></h1>
        @php
            $user = $order->user();
        @endphp
        <h2>Cliente:</h2>
        <p>{{ 'COD.: ' . $user->id . ' - ' . $user->name . ' ' . $user->extra->surname }}</p>

        <h2>Endereço:</h2>
        <p>{{ $order->address . ', ' . $order->number . ' - ' . $order->district }}</p>
        @if ($order->delivery == 'pickup')
            <p><u>Obs.: O cliente optou por buscar a compra no seu estabelecimento.</u></p>
        @else
            <p><u>Obs.:O cliente deseja que a compra seja entregue no endereço dele.</u></p>
        @endif

        <h2>Forma de Pagamento:</h2>
        <p>{{ $order->payment }}</p>

        <h2>Itens do pedido:</h2>
        <table border="1">
            <thead>
                <th class="text-center min">COD</th>
                <th class="text-center">Produtos Vendidos</th>
                <th class="text-center min">Marca</th>
                <th class="text-center min">Quantidade</th>
                <th class="text-center min">Preço</th>
            </thead>
            <tbody>
                    @foreach ($order->items()->get() as $item)
                    <tr>
                        @php
                            $product = $item->product();
                        @endphp
                        <td class="min">{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td class="min">{{ $product->brand }}</td>
                        <td class="min">{{ $item->qty }}</td>
                        <td class="min">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        <table class="col-6 col-offset-6">
            <thead>
                <tr>
                    <th class="text-right min">Subtotal</th>
                    <th class="text-right">{{ 'R$ '. number_format($order->subtotal, 2, ',', '.') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-right min">Valor da entrega</td>
                    <td class="text-right">{{ 'R$ '. number_format($order->delivery_fee, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="text-right min">Total a pagar</th>
                    <th class="text-right">{{ 'R$ '. number_format($order->total, 2, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
        <br>
        <button type="button" name="button" onclick="window.print()">IMPRIMIR</button>
    </body>
</html>
