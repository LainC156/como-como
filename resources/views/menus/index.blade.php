@extends('layouts.app')
@section('title')
    {{ __('Menus disponibles') }} | {{ __('¿Cómo como?') }}
@endsection
@section('content')
    @include('users.partials.header', ['title' => __('Menús de').': '.$patient->name.' '.$patient->last_name ])
    <div class="container-fluid mt--7">
        <input type="hidden" id="list_user_menus_route" value="{{ route('menu.index', [$patient->id]) }}">
        <input type="hidden" id="update_menu_route" value="{{ route('menu.update') }}">
        <input type="hidden" id="delete_menu_route" value="{{ route('menu.delete') }}">
        <input type="hidden" id="menu_type_1" value="{{ __('Menú propio') }}">
        <input type="hidden" id="menu_type_2" value="{{ __('Menú guardado desde otro usuario') }}">
        <input type="hidden" id="menu_type_3" value="{{ __('Menú modificado de otro usuario') }}">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="alert alert-danger" style="display: none" role="alert" id="alert_error">
                                <span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span>
                            </div>
                            <div class="alert alert-success" style="display: none" role="alert" id="alert_success">
                                <span><i class="ni ni-check-bold"></i></span>
                            </div>
                        </div>
                        <!-- buttons to create a new menu -->
                        <div class="row">
                            <div class="col">
                                <h5 class="mb-0">{{ __('Nombre') }}: <b class="text-primary">{!! $patient->name !!}
                                        {!! $patient->last_name !!}</b></h5>
                                <h5 class="mb-0">{{ __('Requerimiento calórico') }}: <b
                                        class="text-primary">{!! $patient->caloric_requirement !!} {{ __('calorías') }}</b></h5>
                            </div>
                            <div class="col text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('menu.create', [$patient->id]) }}"
                                    target="_blank">
                                    <i class="ni ni-fat-add"> {{ __('Crear menú') }} </i>
                                </a>
                            </div>
                        </div>
                        <!-- show all menus in DataTables -->
                        <div class="row">
                            <div class="table-responsive">
                                <table id="menus_table" class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('Acciones') }}</th>
                                            <th scope="col">{{ __('Nombre') }}</th>
                                            <th scope="col">{{ __('Descripción') }}</th>
                                            <th scope="col">{{ __('Tipo de menú') }}</th>
                                            <th scope="col">{{ __('Fecha de creación') }}</th>
                                            <th scope="col">{{ __('Fecha de actualización') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('helpers.alerts')
        @include('helpers.menus.showMenu')
        @include('helpers.menus.saveMenu')
        @include('helpers.menus.deleteMenu')
        @include('layouts.footers.auth')
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/menus/index.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
