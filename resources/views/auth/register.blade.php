@extends('layouts.signinup', ['title' => 'Cadastro'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <panel title="Cadastre-se">
                @if (request('type') == App\Lojista::type)
                    @include('includes.signup.lojista')
                @else
                    @include('includes.signup.cliente')
                @endif
            </panel>
        </div>
    </div>
</div>
@endsection
