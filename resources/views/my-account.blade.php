@extends('layouts.user', ['title' => App\Lojista::type == $user->type ? 'Minha Conta' : 'Meu Cadastro'])

@section('styles')
@parent
    <style>
        .buttons > .iconbutton {
            width: 100%;
        }
        @media (max-width: 991px) {
            .buttons:not(:last-of-type) > .iconbutton {
                margin-bottom: 15px;
            }
        }
        .iconbutton.delete:not(:hover) a {
            background-color: transparent;
            border: 2px solid #a94442;
            color: #a94442;
        }
        .iconbutton.delete:hover a {
            background-color: #a94442;
        }
        .usercontent .iconbutton a {
            min-width: 100% !important;
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
    @if (Session::has('success') || Session::has('fail'))
        $(document).ready(function () {
            $('#alertModal').modal('show');
        });
    @endif
        function saveUser(form) {
            if (form.checkValidity()) {
                $('#saveModal').modal('show');
            }

            event.preventDefault();
        }
        function deleteAccount(confirmed) {
            if (!confirmed) {
                $('#deleteModal').modal('show');
            } else {
                window.location = "{{route('users.delete', $user)}}"
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
                    <h4 class="modal-title">Alterar Meu Cadastro</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente alterar os dados?</p>
                    <p class="text-warning"><small>Essa ação não poderá ser desfeita.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#user-form').submit()">Salvar</button>
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
                    <h4 class="modal-title">Excluir Cadastro</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir a sua conta?</p>
                    <p class="text-warning"><small>Essa ação não poderá ser desfeita.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="deleteAccount(true)">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <panel title="Meu cadastro">
                    @include('includes.user.' . $user->type)
                </panel>
            </div>
        </div>
    </div>
@endsection
