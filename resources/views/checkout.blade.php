@extends('layouts.user', ['title' => 'Checkout'])

@section('styles')
@parent
    <style>
        .market {
            display: inline;
            color: #606060;
        }
        h3 {
            background-color: #E7E7E7;
            color: black;
            font-weight: bold;
            padding: 10px;
            border-radius: 4px;
        }
        h6 {
            padding-left: 16px;
        }
        .panel-body {
            background-color: #EFEFEF !important;
        }
        .newaddress-sec, fieldset {
            background-color: white;
            border-radius: 4px;
            padding: 10px;
        }
        .block {
            display: block;
        }
        .inline {
            display: inline;
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
        }
        tr th:first-child,
        tr td:first-child {
            padding-left: 5px;
        }
        tr th:last-child,
        tr td:last-child {
            padding-right: 5px;
        }
        table .min {
            width: 1%;
            white-space: nowrap;
        }
        .buttons {
            padding: 10px 10px 0;
        }
        .buttons .iconbutton {
            float: right;
        }
        .iconbutton:not(:last-child) {
            margin: 0 !important;
        }
        .iconbutton.cancel-order a:not(:hover) {
            background-color: transparent;
            border: 2px solid #a94442;
            color: #a94442;
        }
        .iconbutton.cancel-order a:hover {
            background-color: #a94442;
        }
        @media (min-width: 1267px) {
            .iconbutton.cancel-order {
                margin-right: 15px;
            }
        }
        @media (max-width: 1267px) {
            .buttons .iconbutton {
                width: 100%;
            }
            .iconbutton.cancel-order {
                margin-top: 15px;
            }
            .buttons .iconbutton a {
                max-width: none;
            }
        }
        .iconbutton.cancel-order a {
            min-width: 150px;
        }
        @if (!Session::has('cart'))
        .empty {
            background-color: white;
            border-radius: 4px;
            width: 100%;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
        }
        .text-info {
            color: #17a2b8;
            text-decoration: none;
        }
        @endif
    </style>
@stop

@section('scripts')
@parent
    <script type="text/javascript">
    @if (Session::has('success') || Session::has('fail'))
        $(document).ready(function () {
            $('#alertModal').modal('show');
        });
    @endif
        $(window).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('input[type="radio"][name="delivery"]').click(function() {
                $('.newaddress-sec *').prop( 'disabled', ('newaddress' !== $(this).val()) );
                if ('newaddress' !== $(this).val()) {
                    clearFee();
                } else if (0.00 != $('input[name="total"]').val()) {
                    updateDeliveryFee();
                }
            });
        });
        function clearFee() {
            $.ajax({
                method: 'POST',
                url: '{{ route('deliveryfee.clear') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    $('.deliveryfee').html('R$ 0,00');
                    $('input[name="deliveryfee"]').val(0.0);

                    $('.total').html($('.subtotal').html());
                    $('input[name="total"]').val($('input[name="subtotal"]').val());
                }
            });
        }
        function finishCheckout(form) {
            if (form.checkValidity()) {
                $('#finishModal').modal('show');
            }

            event.preventDefault();
        }
        function cancelOrder(confirmed) {
            if (!confirmed) {
                $('#cancelModal').modal('show');
            } else {
                window.location = "{{ route('cart.clear') }}";
            }
        }
        function removeItem(confirmed, url) {
            if (!confirmed) {
                window.removeItemUrl = url;
                $('#removeItemModal').modal('show');
            } else {
                window.location = window.removeItemUrl;
            }
        }
        function updateDeliveryFee() {
            $.ajax({
                method: 'POST',
                url: '{{ route('deliveryfee.find') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    delivery: {
                        address: $('#address').val(),
                        number: $('#number').val(),
                        district: $('#district').val(),
                    }
                },
                success: function(data) {
                    $('.deliveryfee').html(data.deliveryfee_formatted);
                    $('input[name="deliveryfee"]').val(data.deliveryfee);

                    $('.total').html(data.total_formatted);
                    $('input[name="total"]').val(data.total);
                }
            });
        }
    </script>
@stop

@section('usercontent')
    @if (Session::has('success') || Session::has('fail'))
        <!-- Modal HTML -->
        <div id="alertModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Mensagem</h4>
                    </div>
                    <div class="modal-body">
                        <p>{!! Session::has('success') ? Session::get('success') : Session::get('fail') !!}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Save Modal HTML -->
    <div id="finishModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Finalizar Pedido</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente finalizar o pedido?</p>
                    <p class="text-warning"><small>Essa ação não poderá ser desfeita.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#form-checkout').submit()">Finalizar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal HTML -->
    <div id="cancelModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Cancelar Pedido</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente cancelar o pedido?</p>
                    <p class="text-warning"><small>Essa ação não poderá ser desfeita.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="cancelOrder(true)">Sim</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Remove Item Modal HTML -->
    <div id="removeItemModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Remover Item</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente remover o item do pedido?</p>
                    <p class="text-warning"><small>Essa ação não poderá ser desfeita.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="removeItem(true)">Sim</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            @if (Session::has('cart'))
                <div class="col-md-12">
                    <panel title="Efetuar Compra em ">
                        <h1 slot="title" class="market">{{ $market->name }}</h1>
                        <form id="form-checkout" class="form-horizontal" method="POST" onsubmit="finishCheckout(this)" action="{{route('checkout')}}">
                            {{ csrf_field() }}

                            <div class="col-md-4 p-xs-0">
                                <h3><i class="fas fa-truck"></i> Forma de entrega</h3>
                                <fieldset>
                                    <label>
                                        <input id="rd-pickup" type="radio" name="delivery" value="pickup" required>
                                        <h4 class="m-0 inline">Vou buscar na empresa</h4>
                                    </label>
                                    <h6 class="mt-0">{{ $market->extra->address }}, {{ $market->extra->number }} - {{ $market->extra->district }}</h6>

                                    <label>
                                        <input id="rd-newaddress" type="radio" name="delivery" value="newaddress">
                                        <h4 class="m-0 inline">Cadastrar um novo endereço</h4>
                                    </label>
                                </fieldset>
                                <br>
                                <div class="newaddress-sec col-md-12">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} col-md-12">
                                        <label for="address" class="col-md-4 p-sm-xs-0 control-label">Endereço</label>

                                        <div class="col-md-8 p-0">
                                            <input id="address" type="text" class="form-control" name="address" value="{{ $cart['delivery']['address'] }}" disabled required{{ $errors->has('address') ? ' autofocus' : '' }}>

                                            @if ($errors->has('address'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }} col-md-12">
                                        <label for="number" class="col-md-4 p-sm-xs-0 control-label">Número</label>

                                        <div class="col-md-8 p-0">
                                            <input id="number" type="text" class="form-control" name="number" value="{{ $cart['delivery']['number'] }}" disabled required{{ $errors->has('number') ? ' autofocus' : '' }}>

                                            @if ($errors->has('number'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('number') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }} col-md-12 mb-0">
                                        <label for="district" class="col-md-4 p-sm-xs-0 control-label">Bairro</label>

                                        <div class="col-md-8 p-0">
                                            <input id="district" type="text" class="form-control" name="district" onkeyup="updateDeliveryFee()" value="{{ $cart['delivery']['district'] }}" disabled required{{ $errors->has('district') ? ' autofocus' : '' }}>

                                            @if ($errors->has('district'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('district') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 p-xs-0">
                                <h3><i class="far fa-credit-card"></i> Forma de pagamento</h3>
                                <fieldset>
                                    <h4 style="font-weight: bold;" class="mt-0">Máquina de Cartão</h4>

                                    <label class="block">
                                        <input type="radio" name="payment" value="Banricompras" required>
                                        <h4 class="m-0 inline">Banricompras</h4>
                                    </label>

                                    <label class="block">
                                        <input type="radio" name="payment" value="ELO - Crédito">
                                        <h4 class="m-0 inline">ELO - Crédito</h4>
                                    </label>

                                    <label class="block">
                                        <input type="radio" name="payment" value="ELO - Débito">
                                        <h4 class="m-0 inline">ELO - Débito</h4>
                                    </label>

                                    <label class="block">
                                        <input type="radio" name="payment" value="MasterCard - Crédito">
                                        <h4 class="m-0 inline">MasterCard - Crédito</h4>
                                    </label>

                                    <label class="block">
                                        <input type="radio" name="payment" value="MasterCard - Débito">
                                        <h4 class="m-0 inline">MasterCard - Débito</h4>
                                    </label>

                                    <label class="block">
                                        <input type="radio" name="payment" value="Visa - Crédito">
                                        <h4 class="m-0 inline">Visa - Crédito</h4>
                                    </label>

                                    <label class="block">
                                        <input type="radio" name="payment" value="Visa - Débito">
                                        <h4 class="m-0 inline">Visa - Débito</h4>
                                    </label>

                                    <label class="block">
                                        <input type="radio" name="payment" value="VR - Vale">
                                        <h4 class="m-0 inline">VR - Vale</h4>
                                    </label>

                                    <h4 style="font-weight: bold;">Outros</h4>

                                    <label class="block">
                                        <input type="radio" name="payment" value="Dinheiro">
                                        <h4 class="m-0 inline">Dinheiro</h4>
                                    </label>
                                </fieldset>
                            </div>
                            <div class="col-md-4 p-xs-0">
                                <h3><i class="fas fa-utensils"></i> Meu pedido</h3>
                                <div class="table-wrapper">
                                    <table class="col-md-12 col-xs-12">
                                        <thead>
                                            <tr>
                                                <th>Produto</th>
                                                <th class="text-right">Qtd.</th>
                                                <th class="text-right">Preço</th>
                                                <th class="min"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="form-control items">
                                            @foreach ($cart['items'] as $id => $item)
                                            <tr>
                                                <td>{{ 'COD.: ' . $id . ' - ' . $item['name'] }}</td>
                                                <td class="text-right">{{ $item['qty'] }}</td>
                                                <td class="text-right">{{ 'R$ '. number_format($item['price'], 2, ',', '.') }}</td>
                                                <td class="min"><a href="javascript:;" onclick="removeItem(false,'{{ route('cart.remove', $id) }}')" style="color: red;">&cross;</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <table class="col-md-12 col-xs-12">
                                    <thead>
                                        <tr>
                                            <th>Subtotal</th>
                                            <th></th>
                                            <th class="subtotal text-right">{{ 'R$ '. number_format($cart['subtotal'], 2, ',', '.') }}</th>
                                            <input type="hidden" name="subtotal" value="{{ $cart['subtotal'] }}">
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="form-control">
                                            <td>Valor da entrega</td>
                                            <td></td>
                                            <td class="deliveryfee text-right">{{ 'R$ '. number_format($cart['delivery']['fee'], 2, ',', '.') }}</td>
                                            <input type="hidden" name="deliveryfee" value="{{ $cart['delivery']['fee'] }}">
                                        </tr>
                                        <tr class="form-control">
                                            <th>Total a pagar</th>
                                            <td></td>
                                            <th class="total text-right">{{ 'R$ '. number_format($cart['total'], 2, ',', '.') }}</th>
                                            <input type="hidden" name="total" value="{{ $cart['total'] }}">
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="buttons col-md-4 col-xs-12 p-xs-0">
                                <iconbutton>Finalizar Pedido</iconbutton>
                                <iconbutton type="button" class="cancel-order" onclick="cancelOrder(false)">Cancelar</iconbutton>
                            </div>
                        </form>
                    </panel>
                </div>
            @else
                <div class="container-fluid empty">
                    <h1>Nenhum item no carrinho.</h1>
                    <a class="text-info" href="{{ route('users.lojista.list') }}">Buscar Supermercados</a>
                </div>
            @endif
        </div>
    </div>
@endsection
