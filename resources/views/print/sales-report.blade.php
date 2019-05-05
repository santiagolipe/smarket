<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Relatório de Vendas - {{ config('app.name', 'Laravel') }}</title>
        <style>
            h1 {
                text-align: center;
            }
            table {
                width: 100%;
            }
        </style>
        <style media="print">
            button {
                display: none;
            }
        </style>
    </head>
    <body>
        <h1>Relatório de Vendas</h1>
        <table border="1">
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
            </tbody>
        </table>
        <br>
        <button type="button" name="button" onclick="window.print()">IMPRIMIR</button>
    </body>
</html>
