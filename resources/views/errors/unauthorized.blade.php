@extends('layouts.master', ['title' => 'Acesso negado'])

@section('content')
    <mynav class="small center" img="{{ asset('img/logo.png') }}" alt="Smarket" href="{{ route('index') }}"></mynav>
    <div class="content">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <p>{{ $role }}</p>
            </div>
        </div>
    </div>
@endsection
