<form class="form-horizontal" method="POST" action="{{ route('register', ['type' => App\Cliente::type]) }}">
    {{ csrf_field() }}

    <h6 class="text-md-right no-p no-m-t">Os campos marcados com (*) são obrigatórios.</h6>

    <div class="col-md-12 no-p">
        <h3 class="col-md-12"><b>Dados pessoais</b></h3>

        <div class="col-md-12">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                <label for="name" class="col-md-4 control-label">Primeiro Nome*</label>

                <div class="col-md-8">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required{{ ($errors->isEmpty() || $errors->has('name')) ? ' autofocus' : '' }}>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }} col-md-6">
                <label for="surname" class="col-md-5 control-label">Sobrenome*</label>

                <div class="col-md-7">
                    <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required{{ $errors->has('surname') ? ' autofocus' : '' }}>

                    @if ($errors->has('surname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('surname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group{{ $errors->has('reg') ? ' has-error' : '' }} col-md-6">
                <label for="cpf" class="col-md-4 control-label">CPF*</label>

                <div class="col-md-8">
                    <input id="cpf" type="text" class="form-control" name="reg" value="{{ old('reg') }}" required{{ $errors->has('reg') ? ' autofocus' : '' }}>

                    @if ($errors->has('reg'))
                        <span class="help-block">
                            <strong>{{ $errors->first('reg') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-md-6">
                <label for="phone" class="col-md-5 control-label">Telefone*</label>

                <div class="col-md-7">
                    <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone') }}" required{{ $errors->has('phone') ? ' autofocus' : '' }}>

                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-2 control-label">E-Mail*</label>

                <div class="col-md-10">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required{{ $errors->has('email') ? ' autofocus' : '' }}>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6">
                <label for="password" class="col-md-4 control-label">Senha*</label>

                <div class="col-md-8">
                    <input id="password" type="password" class="form-control" name="password" required{{ $errors->has('password') ? ' autofocus' : '' }}>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="password-confirm" class="col-md-5 control-label">Confirmação de Senha*</label>

                <div class="col-md-7">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 no-p">
        <h3 class="col-md-12"><b>Endereço</b></h3>

        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            <label for="email" class="col-md-2 control-label">Endereço*</label>

            <div class="col-md-10">
                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required{{ $errors->has('address') ? ' autofocus' : '' }}>

                @if ($errors->has('address'))
                    <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }} col-md-6">
                <label for="number" class="col-md-4 control-label">Número*</label>

                <div class="col-md-8">
                    <input id="number" type="text" class="form-control" name="number" value="{{ old('number') }}" required{{ $errors->has('number') ? ' autofocus' : '' }}>

                    @if ($errors->has('number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('number') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }} col-md-6">
                <label for="district" class="col-md-5 control-label">Bairro*</label>

                <div class="col-md-7">
                    <input id="district" type="text" class="form-control" name="district" value="{{ old('district') }}" required{{ $errors->has('district') ? ' autofocus' : '' }}>

                    @if ($errors->has('district'))
                        <span class="help-block">
                            <strong>{{ $errors->first('district') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group{{ $errors->has('complement') ? ' has-error' : '' }}">
            <label for="complement" class="col-md-2 control-label">Complemento</label>

            <div class="col-md-10">
                <input id="complement" type="text" class="form-control" name="complement" value="{{ old('complement') }}"{{ $errors->has('complement') ? ' autofocus' : '' }}>

                @if ($errors->has('complement'))
                    <span class="help-block">
                        <strong>{{ $errors->first('complement') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-10 col-md-offset-2">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="terms" required{{ $errors->has('terms') ? ' autofocus' : '' }}> Eu aceito os <a target="_blank" href="{{ route('terms') }}">TERMOS DE USO</a>*
                </label>

                @if ($errors->has('terms'))
                    <span class="help-block">
                        <strong>{{ $errors->first('terms') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn button">
                Cadastrar
            </button>
        </div>
    </div>
</form>
