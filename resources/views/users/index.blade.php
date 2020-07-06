@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Pacientes') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">{{ __('Nuevo paciente') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        @include('helpers.session_status')
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Acciones') }}</th>
                                    <th scope="col">{{ __('Nombre') }}</th>
                                    <th scope="col">{{ __('Apellido') }}</th>
                                    <th scope="col">{{ __('Correo') }}</th>
                                    <th scope="col">{{ __('CURP') }}/{{ __('ID') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $user)
                                    <tr>
                                        <td>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                                @csrf
                                            <a class="btn btn-primary btn-sm" href="{{ route('menu.create', [$user->id]) }}" target="_blank">
                                                <i class="ni ni-fat-add"></i>{{ __('Crear menú') }}
                                            </a>
                                            <a class="btn btn-info btn-sm" href="{{ route('menu.index', [$user->id]) }}" target="_blank"><i class="ni ni-archive-2"></i> {{ __('Ver menus') }}</a>
                                            <a class="btn btn-default btn-sm" href="{{ route('user.edit', [$user->id]) }}" target="_blank">
                                                <i class="far fa-edit"> {{ __('Editar') }} </i>
                                            </a>
                                            <a class="btn btn-warning btn-sm" onclick="confirm('{{ __("¿Estás seguro que quieres borrar este usuario? Esta acción no se puede deshacer.") }}') ? this.parentElement.submit() : ''">
                                                <i class="far fa-trash-alt">{{ __('Borrar') }}</i>
                                            </a>
                                        </form>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{!! $user->last_name !!}</td>
                                        <td>
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </td>
                                        <td>{!! $user->identificator!!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('js/user_index.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
