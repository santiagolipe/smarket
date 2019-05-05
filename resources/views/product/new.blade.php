@extends('layouts.user', ['title' => 'Cadastrar Produto'])

@section('styles')
@parent
    <style>
        .image {
            background-color: white;
            padding: 0;
            border: 1px solid lightgray;
        }
        .image img {
            max-width: 100%;
            width: 100%;
            max-height: 200px;
            min-height: 200px;
            object-position: center;
        }
        .image label {
            margin-bottom: 0;
            cursor: pointer;
        }
        .form-group label {
            text-align: right;
        }
        input:not([type="checkbox"]), textarea {
            width: 100%;
        }
        textarea {
            resize: vertical;
            min-height: 150px;
        }

        .col-md-1-33 ,
        .col-md-10-67 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        @media (min-width: 992px) {
            .col-md-1-33 ,
            .col-md-10-67 {
                float: left;
            }
            .col-md-1-33 {
                width: 11.11111111%;
            }
            .col-md-10-67 {
                width: 88.88888889%;
            }
            .col-md-offset-1-33 {
                margin-left: 11.11111111%;
            }
        }

        @media (max-width: 1299px) {
            #app > .container {
                margin-top: 20px;
            }
        }
    </style>
@stop

@section('scripts')
@parent
    <script type="text/javascript">
    @if (Session::has('success'))
        $(document).ready(function () {
            $('#alertModal').modal('show');
        });
    @endif
        function saveProduct(form) {
            if (form.checkValidity()) {
                $('#saveModal').modal('show');
            }

            event.preventDefault();
        }
        function validateImageType(input){
            if (!input.files || !input.files[0]) {
                return;
            }

            var file = input.files[0];
            var fileName = file.name;
            var idxDot = fileName.lastIndexOf('.') + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            var image = $('#image');
            if (extFile.match('(jpg|jpeg|png)')) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    image.attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                input.value = '';
                image.attr('src', '{{ asset('img/NoImage_770x444.png') }}');
                alert("Apenas arquivos jpg/jpeg e png são permitidos!");
            }
        }
    </script>
@stop

@section('usercontent')
    <!-- Save Modal HTML -->
    <div id="saveModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Salvar Produto</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente cadastrar esse produto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#product-form').submit()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

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
                        <p>{!!  Session::has('success') ? Session::get('success') : Session::get('fail') !!}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <panel title="Cadastre Seus Produtos" body-class="no-in-p">
                    <form id="product-form" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="saveProduct(this)" action="{{route('products.create')}}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} col-md-6 image">
                            <label for="image-input" style="width: 100%;">
                                <img id="image" src="{{ asset('img/NoImage_770x444.png') }}" alt="">
                            </label>
                            <input id="image-input" type="file" name="image" style="display: none" value="{{ old('image') }}" accept="image/png, image/jpeg" onchange="validateImageType(this)">

                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('cod') ? ' has-error' : '' }} col-md-6">
                            <label for="cod" class="col-md-4 control-label">COD.*</label>

                            <div class="col-md-8">
                                <input id="cod" type="text" class="form-control" name="cod" value="{{ $newCod }}" readonly{{ $errors->has('cod') ? ' autofocus' : '' }}>

                                @if ($errors->has('cod'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cod') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                            <label for="name" class="col-md-4 control-label">Nome do Produto*</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required{{ $errors->has('name') ? ' autofocus' : '' }}>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('qty') ? ' has-error' : '' }} col-md-6">
                            <label for="qty" class="col-md-4 control-label">Quantidade*</label>

                            <div class="col-md-8">
                                <input id="qty" type="number" class="form-control" name="qty" value="{{ old('qty') }}" required{{ $errors->has('qty') ? ' autofocus' : '' }}>

                                @if ($errors->has('qty'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('qty') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }} col-md-6">
                            <label for="brand" class="col-md-4 control-label">Marca*</label>

                            <div class="col-md-8">
                                <input id="brand" type="text" class="form-control" name="brand" value="{{ old('brand') }}" required{{ $errors->has('brand') ? ' autofocus' : '' }}>

                                @if ($errors->has('brand'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brand') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dept') ? ' has-error' : '' }} col-md-4">
                            <label for="dept" class="col-md-4 control-label">Depart.*</label>

                            <div class="col-md-8">
                                <input id="dept" type="text" class="form-control" name="dept" value="{{ old('dept') }}" required{{ $errors->has('dept') ? ' autofocus' : '' }}>

                                @if ($errors->has('dept'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dept') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('weight') ? ' has-error' : '' }} col-md-4">
                            <label for="weight" class="col-md-4 control-label">Peso (kg)*</label>

                            <div class="col-md-8">
                                <input id="weight" type="number" step="any" class="form-control" name="weight" value="{{ old('weight') }}" required{{ $errors->has('weight') ? ' autofocus' : '' }}>

                                @if ($errors->has('weight'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('weight') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }} col-md-4">
                            <label for="price" class="col-md-4 control-label">Preço*</label>

                            <div class="col-md-8">
                                <input id="price" type="number" step="any" class="form-control" name="price" value="{{ old('price') }}" required{{ $errors->has('price') ? ' autofocus' : '' }}>

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('desc') ? ' has-error' : '' }} col-md-12" style="margin-bottom: 0;">
                            <label for="desc" class="col-md-1-33 control-label">Descrição*</label>

                            <div class="col-md-10-67">
                                <textarea id="desc" class="form-control" name="desc" required{{ $errors->has('desc') ? ' autofocus' : '' }}>{{ old('desc') }}</textarea>

                                @if ($errors->has('desc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('desc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
                            <div class="col-md-10-67 col-md-offset-1-33">
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

                        <div class="col-md-4 col-md-offset-4 buttons">
                            <iconbutton type="submit">Cadastrar</iconbutton>
                        </div>
                    </form>
                </panel>
            </div>
        </div>
    </div>
@endsection
