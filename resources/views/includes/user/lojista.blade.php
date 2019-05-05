@section('styles')
@parent
    <style>
        .logo {
            background-color: white;
            padding: 0;
            border: 1px solid lightgray;
        }
        .logo img {
            max-width: 100%;
            width: 100%;
            max-height: 200px;
            min-height: 200px;
            object-position: center;
        }
        .logo label {
            margin-bottom: 0;
            cursor: pointer;
        }
        .form-group label {
            text-align: right;
        }
    </style>
@stop

@section('scripts')
@parent
    <script type="text/javascript">
        var reader = new FileReader();
        window.onload = function() {
            reader.onload = function(e) {
                $('#logo').attr('src', e.target.result);
            };
        };

        function validateImageType(input){
            if (!input.files || !input.files[0]) {
                return;
            }

            var file = input.files[0];
            var fileName = file.name;
            var idxDot = fileName.lastIndexOf('.') + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            var logo = $('#logo');
            if (extFile.match('(jpg|jpeg|png)')) {
                reader.readAsDataURL(input.files[0]);
            } else {
                input.value = '';
                logo.attr('src', '{{ asset('img/NoImage_770x444.png') }}');
                alert("Apenas arquivos jpg/jpeg e png são permitidos!");
            }
        }
    </script>
@stop

<form id="user-form" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="saveUser(this)" action="{{route('users.update', $user)}}">
    {{ csrf_field() }}
    {{ method_field('patch') }}

    @if (Session::has('success') || Session::has('fail'))
        <!-- Modal HTML -->
        <div id="alertModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Alterar Minha Conta</h4>
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

    <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }} col-md-6 p-0 logo">
        <label for="logo-input" style="width: 100%;">
            <img id="logo" src="{{ asset($user->extra->logo ? $user->extra->logo : 'img/NoImage_770x444.png') }}" alt="">
        </label>
        <input id="logo-input" type="file" name="logo" style="display: none" value="{{ $user->extra->logo ? asset($user->extra->logo) : '' }}" accept="image/png, image/jpeg" onchange="validateImageType(this)">

        @if ($errors->has('logo'))
            <span class="help-block">
                <strong>{{ $errors->first('logo') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6 p-0">
        <label for="name" class="col-md-5 p-0 control-label">Nome Fantasia*</label>

        <div class="col-md-7 p-sm-xs-0">
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}" required{{ $errors->has('name') ? ' autofocus' : '' }}>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('companyname') ? ' has-error' : '' }} col-md-6 p-0">
        <label for="companyname" class="col-md-5 p-0 control-label">Razão Social*</label>

        <div class="col-md-7 p-sm-xs-0">
            <input id="companyname" type="text" class="form-control" name="companyname" value="{{ old('companyname') ? old('companyname') : $user->extra->companyname }}" required{{ $errors->has('companyname') ? ' autofocus' : '' }}>

            @if ($errors->has('companyname'))
                <span class="help-block">
                    <strong>{{ $errors->first('companyname') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('reg') ? ' has-error' : '' }} col-md-6 p-0">
        <label for="cnpj" class="col-md-5 p-0 control-label">CNPJ*</label>

        <div class="col-md-7 p-sm-xs-0">
            <input id="cnpj" type="text" class="form-control" name="reg" value="{{ old('reg') ? old('reg') : $user->reg }}" required{{ $errors->has('reg') ? ' autofocus' : '' }}>

            @if ($errors->has('reg'))
                <span class="help-block">
                    <strong>{{ $errors->first('reg') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('owner') ? ' has-error' : '' }} col-md-6 p-0">
        <label for="owner" class="col-md-5 p-0 control-label">Nome do Proprietário*</label>

        <div class="col-md-7 p-sm-xs-0">
            <input id="owner" type="text" class="form-control" name="owner" value="{{ old('owner') ? old('owner') : $user->extra->owner }}" required{{ $errors->has('owner') ? ' autofocus' : '' }}>

            @if ($errors->has('owner'))
                <span class="help-block">
                    <strong>{{ $errors->first('owner') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-12 p-0">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-6">
            <label for="email" class="col-md-4 p-0 control-label">E-mail*</label>

            <div class="col-md-8 p-sm-xs-0">
                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') ? old('email') : $user->email }}" required{{ $errors->has('email') ? ' autofocus' : '' }}>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
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
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6">
            <label for="password" class="col-md-4 p-0 control-label">Senha</label>

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
            <label for="password-confirm" class="col-md-5 p-0 control-label">Confirmação de Senha</label>

            <div class="col-md-7 p-sm-xs-0">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
            </div>
        </div>

        <div class="form-group{{ $errors->has('desc') ? ' has-error' : '' }} col-md-12">
            <label for="desc" class="col-md-2 p-0 control-label">Descrição*</label>

            <div class="col-md-10 p-sm-xs-0">
                <input id="desc" type="text" class="form-control" name="desc" value="{{ old('desc') ? old('desc') : $user->extra->desc }}" required{{ $errors->has('desc') ? ' autofocus' : '' }}>

                @if ($errors->has('desc'))
                    <span class="help-block">
                        <strong>{{ $errors->first('desc') }}</strong>
                    </span>
                @endif
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

    <div class="form-group{{ $errors->has('defaultdeliveryfee') ? ' has-error' : '' }} col-md-12 p-0">
        <label for="defaultdeliveryfee" class="col-md-2 p-0 control-label">Taxa de Envio Padrão*</label>

        <div class="col-md-10 p-sm-xs-0">
            <input id="defaultdeliveryfee" type="number" step="0.01" min="0" class="form-control" name="defaultdeliveryfee" value="{{ old('defaultdeliveryfee') ? old('defaultdeliveryfee') : $user->extra->default_delivery_fee }}" required{{ $errors->has('defaultdeliveryfee') ? ' autofocus' : '' }}>

            @if ($errors->has('defaultdeliveryfee'))
                <span class="help-block">
                    <strong>{{ $errors->first('defaultdeliveryfee') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
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
            <iconbutton type="submit">Salvar</iconbutton>
        </div>
        <div class="col-md-4 p-sm-xs-0 buttons">
            <iconbutton type="button" class="delete" onclick="deleteAccount()">Excluir</iconbutton>
        </div>
    </div>
</form>
