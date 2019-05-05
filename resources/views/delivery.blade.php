@extends('layouts.user', ['title' => 'Dados de Entrega'])

@php
    $deliveries = $paginator->items();
@endphp

@section('styles')
@parent
    <style>
        .form-search {
            padding: 0;
        }
        .buttons > .iconbutton {
            width: 100%;
        }
        .buttons > .iconbutton a {
            min-width: unset;
            max-width: none;
        }
        .iconbutton.reset:not(:hover) a {
            background-color: transparent;
            border: 2px solid #020852;
            color: #020852;
        }
        .iconbutton.reset:hover a {
            background-color: #020852;
        }
        .iconbutton.cancel:not(:hover) a {
            background-color: transparent;
            border: 2px solid #a94442;
            color: #a94442;
        }
        .iconbutton.cancel:hover a {
            background-color: #a94442;
        }
        @media (max-width: 991px) {
            .buttons:not(:last-of-type) > .iconbutton {
                margin-bottom: 15px;
            }
        }
        table.deliveries a {
            cursor: pointer;
        }
        table.deliveries a:not([href]),
        table.deliveries a:not([href]):hover {
            color: inherit;
            cursor: default;
            text-decoration: none;
        }
        .table-responsive {
            overflow-y: auto;
            max-height: 100%;
        }
        .table-responsive .empty {
            border: 1px solid gray;
        }
        table.deliveries > tbody td {
            border: 1px solid gray;
        }
        table.deliveries > thead {
            background-color: gray;
            color: white;
        }
        table.deliveries > thead,
        table.deliveries > thead th {
            border: 1px solid black;
        }
        table.deliveries tbody {
            border-color: gray;
        }
        table.deliveries .min {
            width: 1%;
            white-space: nowrap;
        }
        table.deliveries > tbody td + td + td,
        table.deliveries > tbody td + td + td + td, {
            background-color: gray;
        }
        table.deliveries > thead th,
        table.deliveries > tbody td {
            padding-left: 15px;
            padding-right: 15px;
        }
        .pagination {
            display: inline-flex;
            overflow-x: auto;
            max-width: 60%;
        }
        .pagination > li > a,
        .pagination > li > span {
            color: #333333;
        }
        .pagination > li > a:hover,
        .pagination > li > a:focus,
        .pagination > li > span:hover,
        .pagination > li > span:focus {
            color: #636b6f;
        }
        .pagination > .active > a,
        .pagination > .active > a:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span,
        .pagination > .active > span:hover,
        .pagination > .active > span:focus {
            background-color: #020852;
            border-color: #020852;
        }
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

        .modal-body,
        .button-add {
            width: 100%;
            position: relative;
            display: inline-block;
        }
        .iconbutton.add-delivery {
            float: right;
        }

        @media (max-width: 767px) {
            .iconbutton.add-delivery {
                width: 100%;
            }
            .iconbutton.add-delivery a {
                max-width: none;
            }
        }

        @media (min-width: 992px) {
            .form-search {
                float: right;
                position: absolute;
                top: 0;
                right: 0;
            }
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
        $(document).ready(function () {
            @if (Session::has('success') || Session::has('fail'))
            $('#alertModal').modal('show');
            @endif
            @if (Session::has('open-add') || count($errors) > 0)
            $('#addDeliveryModal').modal('show');
            @endif
        });
        function saveDelivery(form) {
            if (form.checkValidity()) {
                $('#saveModal').modal('show');
            }

            event.preventDefault();
        }
        function updateDelivery(form) {
            if (form.checkValidity()) {
                $('#updateModal').modal('show');
            }

            event.preventDefault();
        }
        function edit(data) {
            // console.log(data.localization);
            $('#editDeliveryModal #localization').val(data.localizationraw);
            $('#editDeliveryModal #time').val(data.time);
            $('#editDeliveryModal #fee').val(data.fee);

            $('#edit-delivery-form').attr('action', '/delivery/' + data.id + '/update');
            $('#editDeliveryModal').modal('show');
            event.preventDefault();
        }
        function deleteDelivery(confirmed, route) {
            if (!confirmed) {
                window.deleteRoute = route;
                $('#deleteModal').modal('show');
            } else {
                window.location = window.deleteRoute;
            }
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

        $('div.markets > .market').each(function() {
            $(this).resize(function() {
                $(this).height($(this).width());
            });
        });
    </script>
@stop

@section('usercontent')
    <!-- Add Delivery Modal HTML -->
    <div id="addDeliveryModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center">Adicionar Dados de Entrega</h4>
                </div>
                <form id="add-delivery-form" class="form-horizontal" action="{{ route('deliveryfee.create') }}" method="POST" onsubmit="saveDelivery(this)">
                    <div class="modal-body">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('localization') ? ' has-error' : '' }} col-md-12 p-0">
                            <label for="localization" class="col-md-3 p-0 control-label">Localização</label>

                            <div class="col-md-9 p-sm-xs-0">
                                <input id="localization" type="text" class="form-control" name="localization" value="{{ old('localizationraw') }}" required{{ $errors->has('localization') ? ' autofocus' : '' }}>

                                @if ($errors->has('localization'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('localization') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('time') ? ' has-error' : '' }} col-md-12 p-0">
                            <label for="time" class="col-md-3 p-0 control-label">Tempo de Entrega (min)</label>

                            <div class="col-md-9 p-sm-xs-0">
                                <input id="time" type="number" step="1" class="form-control" name="time" value="{{ old('time') }}" required{{ $errors->has('time') ? ' autofocus' : '' }}>

                                @if ($errors->has('time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('fee') ? ' has-error' : '' }} col-md-12 p-0">
                            <label for="fee" class="col-md-3 p-0 control-label">Taxa de Entrega (R$)</label>

                            <div class="col-md-9 p-sm-xs-0">
                                <input id="fee" type="number" step="any" class="form-control" name="fee" value="{{ old('fee') }}" required{{ $errors->has('fee') ? ' autofocus' : '' }}>

                                @if ($errors->has('fee'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fee') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group col-md-12 p-0 mb-0">
                            <div class="col-md-4 p-sm-xs-0 buttons">
                                <iconbutton type="submit">Adicionar</iconbutton>
                            </div>
                            <div class="col-md-4 p-sm-xs-0 buttons">
                                <iconbutton class="reset" type="reset">Limpar</iconbutton>
                            </div>
                            <div class="col-md-4 p-sm-xs-0 buttons">
                                <iconbutton class="cancel" type="button" data-dismiss="modal">Cancelar</iconbutton>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Delivery Modal HTML -->
    <div id="editDeliveryModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center">Alterar Dados de Entrega</h4>
                </div>
                <form id="edit-delivery-form" class="form-horizontal" method="POST" onsubmit="updateDelivery(this)">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}

                        <div class="form-group{{ $errors->has('localization') ? ' has-error' : '' }} col-md-12 p-0">
                            <label for="localization" class="col-md-3 p-0 control-label">Localização</label>

                            <div class="col-md-9 p-sm-xs-0">
                                <input id="localization" type="text" class="form-control" name="localization" value="{{ old('localizationraw') }}" required{{ $errors->has('localization') ? ' autofocus' : '' }}>

                                @if ($errors->has('localization'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('localization') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('time') ? ' has-error' : '' }} col-md-12 p-0">
                            <label for="time" class="col-md-3 p-0 control-label">Tempo de Entrega (min)</label>

                            <div class="col-md-9 p-sm-xs-0">
                                <input id="time" type="number" step="1" class="form-control" name="time" value="{{ old('time') }}" required{{ $errors->has('time') ? ' autofocus' : '' }}>

                                @if ($errors->has('time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('fee') ? ' has-error' : '' }} col-md-12 p-0">
                            <label for="fee" class="col-md-3 p-0 control-label">Taxa de Entrega (R$)</label>

                            <div class="col-md-9 p-sm-xs-0">
                                <input id="fee" type="number" step="any" class="form-control" name="fee" value="{{ old('fee') }}" required{{ $errors->has('fee') ? ' autofocus' : '' }}>

                                @if ($errors->has('fee'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fee') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group col-md-12 p-0 mb-0">
                            <div class="col-md-4 p-sm-xs-0 buttons">
                                <iconbutton type="submit">Alterar</iconbutton>
                            </div>
                            <div class="col-md-4 p-sm-xs-0 buttons">
                                <iconbutton class="reset" type="reset">Limpar</iconbutton>
                            </div>
                            <div class="col-md-4 p-sm-xs-0 buttons">
                                <iconbutton class="cancel" type="button" data-dismiss="modal">Cancelar</iconbutton>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Save Modal HTML -->
    <div id="saveModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Salvar Entrega</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente cadastrar essa entrega?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#add-delivery-form').submit()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal HTML -->
    <div id="updateModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Atualizar Entrega</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente atualizar essa entrega?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#edit-delivery-form').submit()">Atualizar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal HTML -->
    <div id="deleteModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Excluir Entrega</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir essa entrega?</p>
                    <p class="text-warning"><small>Essa ação não poderá ser desfeita.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="deleteDelivery(true)">Excluir</button>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <panel title="Dados de Entrega" body-class="no-p">
                    <form slot="header" class="form-search col-md-2" method="GET" action="{{ route('deliveryfee.list') }}" >
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Procurar" name="search" value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-search">
                                    <span class="fas fa-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                    <div class="table-responsive col-md-12 m-0">
                        <table class="table deliveries mb-0 text-center">
                            <thead>
                                <th class="text-center">Localização</th>
                                <th class="text-center min">Tempo Entrega (min)</th>
                                <th class="text-center min">Taxa Entrega (R$)</th>
                                <th class="text-center min">Editar Entrega</th>
                                <th class="text-center min">Deletar Entrega</th>
                            </thead>
                            <tbody>
                                @foreach ($deliveries as $deliveryfee)
                                <tr>
                                    <td>{{ $deliveryfee->localizationraw }}</td>
                                    <td class="min">{{ $deliveryfee->time }}</td>
                                    <td class="min">{{ $deliveryfee->fee }}</td>
                                    <td class="min"><a class="text-info" href="javascript:;" onclick="edit({{ $deliveryfee->toJson() }})">Editar</a></td>
                                    <td class="min"><a class="text-danger" href="javascript:;" onclick="deleteDelivery(false, '{{ route('deliveryfee.delete', $deliveryfee->id) }}')">Excluir</a></td>
                                </tr>
                                @endforeach
                                @if ($paginator->isEmpty())
                                    <tr><td colspan="5"><h1>Nenhuma Entrega</h1></td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($paginator->isNotEmpty())
                        <div slot="footer" class="text-center">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination m-0">
                                    <li class="page-item{{ 1 === $paginator->currentPage() ? ' disabled' : '' }}">
                                        <a class="page-link" aria-label="Anterior" tabindex="-1"{{ 1 !== $paginator->currentPage() ? ' href='.$paginator->previousPageUrl() : '' }}>
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="pagination justify-content-center m-0">
                                    @php
                                    $pages = $paginator->getUrlRange(1, $paginator->lastPage());
                                    @endphp
                                    @for ($i=1; $i <= $paginator->lastPage(); $i++)
                                        <li class="page-item{{ $paginator->currentPage() === $i ? ' active' : '' }}"><a class="page-link"{{ $paginator->currentPage() !== $i ? ' href='.$pages[$i] : '' }}>{{ $i }}</a></li>
                                    @endfor
                                </ul>
                                <ul class="pagination m-0">
                                    <li class="page-item{{ $paginator->lastPage() === $paginator->currentPage() ? ' disabled' : '' }}">
                                        <a class="page-link" aria-label="Próxima" tabindex="-1"{{ $paginator->lastPage() !== $paginator->currentPage() ? ' href='.$paginator->nextPageUrl() : '' }}>
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Próxima</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    @endif
                    <div slot="footer" class="button-add">
                        <iconbutton class="add-delivery" data-toggle="modal" data-target="#addDeliveryModal">Adicionar</iconbutton>
                    </div>
                </panel>
            </div>
        </div>
    </div>
@endsection
