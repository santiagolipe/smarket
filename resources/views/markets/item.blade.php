@extends('layouts.market', ['back' => route('users.lojista.items', $market->id), 'title' => $product->name])

@section('styles')
@parent
    <style>
        .name {
            color: black;
        }
        .price {
            text-align: center;
            font-size: 48px;
            color: black;
        }
        .form-group label {
            line-height: 36px;
        }
        .product img {
            max-height: 200px;
        }
        .buttons .iconbutton:not(:last-child) {
            margin-right: 15px !important;
        }
        .buttons {
            float: right;
            padding: 15px;
        }
        .iconbutton.add-to-cart:not(:hover) a {
            background-color: transparent;
            border: 2px solid #020852;
            color: #020852;
        }
        @media (max-width: 520px) {
            .buttons .iconbutton:not(:first-of-type) {
                margin-top: 15px;
            }
            .buttons,
            .buttons .iconbutton,
            .buttons .iconbutton > a {
                width: 100%;
                max-width: 100%;
            }
        }
        @media (max-width: 992px) {
            .name {
                text-align: center;
            }
        }
        @media (min-width: 768px) {
            label[for="qty"] {
                float: right;
            }
        }
        @if ($product->qty == 0)
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
    @if (Session::has('success') || Session::has('fail'))
    <script type="text/javascript">
        $(document).ready(function () {
            $('#alertModal').modal('show');
        });
    </script>
    @endif
@stop

@section('marketcontent')
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

    @if ($product->qty != 0)
        <form action="{{ route('cart.buy') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="productId" value="{{ $product->id }}">

            <div class="name h1 mt-0 col-md-12">{{ $product->name }}</div>
            <div class="col-md-6 no-p">
                <div class="product col-md-6 col-sm-6 col-xs-12">
                    <img class="img" width="100%" height="100%" src="{{ asset($product->image ? $product->image : 'img/NoImage_592x444.png') }}" alt="{{ $product->name }}">
                    <div class="h5">COD.: {{ $product->id }}</div>
                </div>

                <div class="form-group col-md-6 col-sm-6">
                    <label for="weight" class="col-md-3 col-sm-3 p-xs-0 control-label">Peso</label>

                    <div class="col-md-9 col-sm-9 p-xs-0">
                        <input id="weight" type="text" class="form-control" value="{{ number_format($product->weight, 2, ',', '.') . ' Kg' }}" readonly>
                    </div>
                </div>

                <div class="form-group col-md-6 col-sm-6">
                    <label for="brand" class="col-md-3 col-sm-3 p-xs-0 control-label">Marca</label>

                    <div class="col-md-9 col-sm-9 p-xs-0">
                        <input id="brand" type="text" class="form-control" value="{{ $product->brand }}" readonly>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('qty') ? ' has-error' : '' }} col-md-6 col-sm-6">
                    <label for="qty" class="col-md-4 col-sm-4 p-xs-0 control-label" style="text-align: left;">Unidades</label>

                    <div class="col-md-5 col-md-offset-3 col-sm-offset-3 col-sm-5 p-xs-0">
                        <input id="qty" type="number" step="1" class="form-control" name="qty" value="1" min="1" max="{{ $product->qty }}" required{{ $errors->has('qty') ? ' autofocus' : '' }}>

                        @if ($errors->has('qty'))
                            <span class="help-block">
                                <strong>{{ $errors->first('qty') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="price">{{ 'R$ '. number_format($product->price, 2, ',', '.') }}</div>
            </div>
            <div class="col-md-6 p-0">
                <div class="form-group col-md-12 p-0" style="margin-bottom: 0;">
                    <label for="desc" class="col-md-12 p-sm-xs-0 control-label" style="text-align: left;line-height: 1;">Descrição*</label>

                    <div class="col-md-12 p-sm-xs-0">
                        <textarea id="desc" class="form-control" name="desc" readonly>{{ $product->desc }}</textarea>
                    </div>
                </div>

                <div class="buttons">
                    <iconbutton formaction="{{ route('cart.buy') }}">Comprar Agora</iconbutton>
                    <iconbutton class="add-to-cart" formaction="{{ route('cart.add') }}">Adicionar ao Carrinho</iconbutton>
                </div>
            </div>
        </form>
    @else
        <div class="container-fluid empty">
            <h1>Produto indisponível.</h1>
            <a class="text-info" href="{{ route('users.lojista.items', $market->id) }}">Buscar Produtos</a>
        </div>
    @endif

@endsection
