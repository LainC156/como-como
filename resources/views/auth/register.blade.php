@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <!-- Table -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small class="text-red">{{ __('Todos los campos son obligatorios, excepto CURP/ID') }}</small>
                        </div>
                        <!-- NAME -->
                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                <input class="form-control" placeholder="{{ __('Nombre') }}" type="text" name="name" id="registration_name" value="" autofocus required>
                            </div>
                        </div>
                        <!-- LAST NAME -->
                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                <input class="form-control" placeholder="{{ __('Apellidos') }}" type="text" name="last_name" id="registration_last_name" value="" autofocus>
                            </div>
                        </div>
                        <!-- CURP/ID -->
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                </div>
                                <input class="form-control" placeholder="{{ __('CURP O ID') }}" type="text" name="register_id" id="registration_id" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <!-- EMAIL -->
                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control" placeholder="{{ __('Correo') }}" type="email" name="email" id="registration_email" value="">
                            </div>
                        </div>
                        <!-- PASSWORD -->
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" placeholder="{{ __('Contraseña') }}" type="password" name="password" id="registration_password">
                            </div>
                        </div>
                        <!-- PASSWORD CONFIRMATION -->
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" placeholder="{{ __('Confirma contraseña') }}" type="password" name="password_confirmation" id="registration_password_confirmation">
                            </div>
                        </div>
                        <div class="text-muted font-italic">
                            <small class="text-success font-weight-700">{{ __('La contraseña debe de ser de al menos 8 caracteres') }}</small>
                        </div>
                        <!-- kind of subscription -->
                        <div class="form-group text-center">
                            <small class="text-muted">{{ __('Selecciona un tipo de cuenta') }}</small>
                            <select class="form-control btn btn-primary required" id="account_type" name="register_subscription">
                                <option value="2" selected>{{ __('Nutriólogo') }}</option>
                                <option value="3">{{ __('Paciente') }}</option>
                            </select>
                        </div>
                        <!--
                        <div class="row my-4">
                            <div class="col-12">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id="customCheckRegister" type="checkbox">
                                    <label class="custom-control-label" for="customCheckRegister">
                                        <span class="text-muted">{{ __('I agree with the') }} <a href="#!">{{ __('Privacy Policy') }}</a></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        -->
                        @include('helpers.alerts')
                        <div class="text-center">
                            <button type="submit" id="register_btn" class="btn btn-primary mt-4">{{ __('Crear cuenta') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('js/register.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
