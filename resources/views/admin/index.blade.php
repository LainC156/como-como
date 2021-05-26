@extends('layouts.app', ['title' => __('Users Management')])
@section('title')
    {{ isset($patients) ? __('Pacientes') : __('Nutriólogos') }} | {{ __('¿Cómo como?') }}
@endsection

@section('content')
    @include('users.partials.header', ['title' => isset($patients) ? __('Pacientes') : __('Nutriólogos')])
    <div class="container-fluid mt--7">
        <input type="hidden" id="users_list"
            value="{{ isset($patients) ? route('patients.index') : route('nutritionists.index') }}">
        <input type="hidden" id="false" value="{{ __('No activa') }}">
        <input type="hidden" id="true" value="{{ __('Activa') }}">
        <input type="hidden" id="update_user_url" value="{{ route('user.update.asadmin') }}">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="text-description text-primary">
                            {{ __('Modificar tipo de suscripción de todos los usuarios registrados') }}
                        </div>
                        <div>
                            <span class="text-warning">{{ __('Nota') }}:
                                {{ __('se muestran todos los registros de pagos existentes en la base de datos, están ordenados por fecha del último pago en orden descendente') }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="users_table" class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('User ID') }}</th>
                                        <th scope="col">{{ __('Fecha último pago') }}</th>
                                        <th scope="col">{{ __('Pago expira en') }}</th>
                                        <th scope="col">{{ __('Nombre') }}</th>
                                        <th scope="col">{{ __('Apellidos') }}</th>
                                        <th scope="col">{{ __('Correo electrónico') }}</th>
                                        <th scope="col">{{ __('Suscripción') }}</th>
                                        <th scope="col">{{ __('Versión de prueba') }}</th>
                                        <th scope="col">{{ __('Fecha de creación') }}</th>
                                        <th scope="col">{{ __('Última actualización') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div> <!-- end table -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('helpers.admin.editUser')
    @include('layouts.footers.auth')
@endsection
@section('javascript')
    <script src="{{ asset('js/admin/index.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
