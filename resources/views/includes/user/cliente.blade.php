<form id="user-form" class="form-horizontal" method="POST" onsubmit="saveUser(this)" action="{{route('users.update', $user)}}">
    {{ csrf_field() }}
    {{ method_field('patch') }}

    @if (Session::has('success') || Session::has('fail'))
        <!-- Modal HTML -->
        <div id="alertModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Alterar Meu Cadastro</h4>
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

    <h6 class="text-md-right no-p no-m-t">Os campos marcados com (*) são obrigatórios.</h6>

    <h3 class="col-md-12 p-0"><b>Dados pessoais</b></h3>

    <div class="col-md-12 p-0">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
            <label for="name" class="col-md-4 p-0 control-label">Primeiro Nome*</label>

            <div class="col-md-8 p-sm-xs-0">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}" required{{ $errors->has('name') ? ' autofocus' : '' }}>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }} col-md-6">
            <label for="surname" class="col-md-5 p-0 control-label">Sobrenome*</label>

            <div class="col-md-7 p-sm-xs-0">
                <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') ? old('surname') : $user->extra->surname }}" required{{ $errors->has('surname') ? ' autofocus' : '' }}>

                @if ($errors->has('surname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('surname') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>



    <div class="col-md-12 p-0">
        <div class="form-group{{ $errors->has('reg') ? ' has-error' : '' }} col-md-6">
            <label for="cpf" class="col-md-4 p-0 control-label">CPF*</label>

            <div class="col-md-8 p-sm-xs-0">
                <input id="cpf" type="text" readonly="true" class="form-control" name="reg" value="{{ old('reg') ? old('reg') : $user->reg }}" required{{ $errors->has('reg') ? ' autofocus' : '' }} >

             @if ($errors->has('reg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('reg') }}</strong>
                    </span>
                @endif 
            </div>
        </div>












        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-md-6">
            <label for="phone" class="col-md-5 p-0 control-label">Telefone*</label>

            <div class="col-md-7 p-sm-xs-0">
                <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone') ? old('phone') : $user->extra->phone }}" required{{ $errors->has('phone') ? ' autofocus' : '' }}>

                @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-12 p-0">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-2 p-0 control-label">E-Mail*</label>

            <div class="col-md-10 p-sm-xs-0">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : $user->email }}" required{{ $errors->has('email') ? ' autofocus' : '' }}>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-12 p-0">
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6">
            <label for="password" class="col-md-4 p-0 control-label">Senha*</label>

            <div class="col-md-8 p-sm-xs-0">
                <input id="password" type="password" class="form-control" name="password"{{ $errors->has('password') ? ' autofocus' : '' }}>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group col-md-6">
            <label for="password-confirm" class="col-md-5 p-0 control-label">Confirmação de Senha*</label>

            <div class="col-md-7 p-sm-xs-0">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
            </div>
        </div>
    </div>

    <h3 class="col-md-12 p-0"><b>Endereço</b></h3>

    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} col-md-12 p-0">
        <label for="email" class="col-md-2 p-0 control-label">Endereço*</label>

        <div class="col-md-10 p-sm-xs-0">
            <input id="address" type="text" class="form-control" name="address" value="{{ old('address') ? old('address') : $user->extra->address }}" required{{ $errors->has('address') ? ' autofocus' : '' }}>

            @if ($errors->has('address'))
                <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-12 p-0">
        <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }} col-md-6">
            <label for="number" class="col-md-4 p-0 control-label">Número*</label>

            <div class="col-md-8 p-sm-xs-0">
                <input id="number" type="text" class="form-control" name="number" value="{{ old('number') ? old('number') : $user->extra->number }}" required{{ $errors->has('number') ? ' autofocus' : '' }}>

                @if ($errors->has('number'))
                    <span class="help-block">
                        <strong>{{ $errors->first('number') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }} col-md-6">
            <label for="district" class="col-md-5 p-0 control-label">Bairro*</label>

            <div class="col-md-7 p-sm-xs-0">
                <input id="district" type="text" class="form-control" name="district" value="{{ old('district') ? old('district') : $user->extra->district }}" required{{ $errors->has('district') ? ' autofocus' : '' }}>

                @if ($errors->has('district'))
                    <span class="help-block">
                        <strong>{{ $errors->first('district') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group{{ $errors->has('complement') ? ' has-error' : '' }} col-md-12 p-0">
        <label for="complement" class="col-md-2 p-0 control-label">Complemento</label>

        <div class="col-md-10 p-sm-xs-0">
            <input id="complement" type="text" class="form-control" name="complement" value="{{ old('complement') ? old('complement') : $user->extra->complement }}"{{ $errors->has('complement') ? ' autofocus' : '' }}>

            @if ($errors->has('complement'))
                <span class="help-block">
                    <strong>{{ $errors->first('complement') }}</strong>
                </span>
            @endif
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

    <div class="form-group col-md-12 p-0 mb-0">
        <div class="col-md-4 col-md-offset-2 p-sm-xs-0 buttons">
            <iconbutton type="submit" data-target="#myModal">Salvar</iconbutton>
        </div>
        <div class="col-md-4 p-sm-xs-0 buttons">
            <iconbutton type="button" class="delete" onclick="deleteAccount()">Excluir</iconbutton>
        </div>
    </div>
</form>
