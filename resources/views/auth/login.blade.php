@extends('layouts.signinup', ['title' => 'Login'])

@section('content')
<div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <panel title="Efetuar Login">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                                <label for="login" class="col-md-4 control-label">CPF/CNPJ ou E-Mail</label>

                                <div class="col-md-8">
                                    <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus>

                                    @if ($errors->has('login'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('login') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Senha</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembre de mim
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">

                                <a class="btn btn-link" href="..\resources\views\index.blade.php">
                                        Esqueceu a senha?
                                </a>

                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn button">
                                        Entrar
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Esqueceu a senha?
                                    </a>

                                </div>
                                
                        </form>
                    </panel>
                </div>
            </div>
        </div>
@endsection
