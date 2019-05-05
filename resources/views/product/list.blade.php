@extends('layouts.user', ['title' => 'Lista de Produtos'])

@php
    $products = $paginator->items();
@endphp

@section('styles')
@parent
    <style>
        .form-search {
            padding: 0;
        }
        table.products a {
            cursor: pointer;
        }
        table.products a:not([href]),
        table.products a:not([href]):hover {
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
        table.products > tbody td {
            border: 1px solid gray;
        }
        table.products > thead {
            background-color: gray;
            color: white;
        }
        table.products > thead,
        table.products > thead th {
            border: 1px solid black;
        }
        table.products tbody {
            border-color: gray;
        }
        table.products .min {
            width: 1%;
            white-space: nowrap;
        }
        table.products > thead th,
        table.products > tbody td {
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
        function deleteProduct(confirmed) {
            if (!confirmed) {
                $('#deleteModal').modal('show');
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

    <!-- Delete Modal HTML -->
    <div id="deleteModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Excluir Produto</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir esse produto?</p>
                    <p class="text-warning"><small>Essa ação não poderá ser desfeita.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="deleteProduct(true)">Excluir</button>
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
                <panel title="Lista de Produtos" body-class="no-p">
                    <form slot="header" class="form-search col-md-2" method="GET" action="{{ route('products.list') }}" >
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Procurar Produtos" name="search" value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-search">
                                    <span class="fas fa-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                    <div class="table-responsive col-md-12 m-0">
                        <table class="table products mb-0 text-center">
                            <thead>
                                <th class="text-center min">COD</th>
                                <th class="text-center">Produto</th>
                                <th class="text-center min">Editar Produto</th>
                                <th class="text-center min">Deletar Produto</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr{!! $product->trashed() ? ' class="danger"' : '' !!}>
                                    <td class="min">{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    @if ($product->trashed())
                                        <td class="min"><a>Editar</a></td>
                                        <td class="min"><a class="text-primary" href="{{ route('products.restore', $product->id) }}">Restaurar</a></td>
                                    @else
                                        <td class="min"><a class="text-info" href="{{ route('products.edit', $product->id) }}">Editar</a></td>
                                        <td class="min"><a class="text-danger" href="{{ route('products.delete', $product->id) }}">Excluir</a></td>
                                    @endif
                                </tr>
                                @endforeach
                                @if ($paginator->isEmpty())
                                    <tr><td colspan="4"><h1>Nenhum Produto</h1></td></tr>
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
                </panel>
            </div>
        </div>
    </div>
@endsection
