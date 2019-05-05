@extends('layouts.master', ['title' => 'Recuperar Acesso'])

@section('content')
<mynav class="small center" img="{{ asset('/img/logo.png') }}" alt="Smarket" href="{{ route('index') }}"></mynav>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <panel title="Reset Password">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">Email</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-default" style="background-color: #020852;color: white;">
                                Enviar Link para recuperar senha
                            </button>
                        </div>
                    </div>
                </form>
            </panel>
        </div>
    </div>
</div>
@endsection
