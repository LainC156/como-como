@extends('layouts.app', ['title' => __('User Management')])
@section('title')
    {{ __('Pacientes') }} | {{ __('¿Cómo como?') }}
@endsection
@section('content')
    @include('users.partials.header', ['title' => __('Pacientes')])

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
                                <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-user-plus"></i> {{ __('Nuevo paciente') }}</a>
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
                                @forelse ($patients as $patient)
                                    <tr>
                                        <td>
                                            <form action="{{ route('user.destroy', $patient->id) }}" method="post">
                                                @csrf
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('menu.create', [$patient->id]) }}" target="_blank">
                                                    <i class="ni ni-fat-add"></i>{{ __('Crear menú') }}
                                                </a>
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('menu.index', [$patient->id]) }}" target="_blank"><i
                                                        class="ni ni-archive-2"></i> {{ __('Ver menus') }}</a>
                                                <a class="btn btn-default btn-sm"
                                                    href="{{ route('user.edit', [$patient->id]) }}" target="_blank">
                                                    <i class="far fa-edit"> {{ __('Editar') }} </i>
                                                </a>
                                                <a class="btn btn-warning btn-sm"
                                                    onclick="confirm('{{ __('¿Estás seguro que quieres borrar este usuario? Esta acción no se puede deshacer.') }}') ? this.parentElement.submit() : ''">
                                                    <i class="far fa-trash-alt">{{ __('Borrar') }}</i>
                                                </a>
                                            </form>
                                        </td>
                                        <td>{{ $patient->name }}</td>
                                        <td>{!! $patient->last_name !!}</td>
                                        <td>
                                            <a href="mailto:{{ $patient->email }}">{{ $patient->email }}</a>
                                        </td>
                                        <td>{!! $patient->identificator !!}</td>
                                    </tr>
                                @empty
                                    <td class="text-center">{{ __('Sin pacientes registrados') }}</td>
                                @endforelse
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
<script src="{{ asset('js/user/index.js') }}"></script>
<script src="{{ asset('js/alerts.js') }}"></script>
@endsection
