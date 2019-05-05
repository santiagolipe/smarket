@extends('layouts.market', ['back' => route('users.lojista.list'), 'title' => $market->name])

@section('marketcontent')
    @foreach ($products as $product)
        <div class="product col-lg-2 col-md-4 col-sm-6 col-xs-12">
            <a title="{{ $product->name }}" href="{{ route('users.lojista.item', ['id' => $market, 'product' => $product->id]) }}">
                <img class="img" width="100%" height="100%" src="{{ asset($product->image ? $product->image : 'img/NoImage_592x444.png') }}" alt="{{ $product->name }}">
                <div class="name">{{ $product->name }}</div>
                <div class="price">{{ 'R$ '. number_format($product->price, 2, ',', '.') }}</div>
            </a>
        </div>
    @endforeach
    @if (empty($products))
        <h1 class="text-center col-lg-12 col-md-12 col-sm-12 col-xs-12 m-0">Nenhum Produto</h1>
    @endif
@endsection
