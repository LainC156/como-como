@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Editar datos del paciente')])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h3 class="mb-0 text-red">{{ __('Campos obligatorios') }} <i
                                        class="fa fa-exclamation-circle"></i></h3>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary"
                                    target="_blank">{{ __('Pacientes registrados') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <input id="user_update_route" type="hidden" value="{{ route('user.update') }}">
                        <input id="home_route" type="hidden" value="{{ route('home') }}">
                        <input type="hidden" id="update_avatar_route"
                            value="{{ route('avatar.update', $patient->user_id) }}">
                        <input type="hidden" value="{!! $patient->id !!}" id="patient_id">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="javascript:void(0)" method="POST" enctype="multipart/form-data"
                                                id="upload_avatar">
                                                <div class="form-group text-center d-inline">
                                                    <!-- <label for="img_image">{{ __('Actualizar foto de perfil') }}</label> -->
                                                    <div class="row">
                                                        <div class="col">
                                                            <img class="responsive text-center"
                                                                style="vertical-align: middle;width: 150px;height: 150px;border-radius: 50%;"
                                                                src="{{ asset('img/avatar/user.jpg') }}" alt="no_img">
                                                        </div>
                                                        <div class="col">
                                                            <div class="col mt-auto">
                                                                <input id="img_avatar" name="avatar" type="file"
                                                                    class="form-control" accept="image/*">
                                                            </div>
                                                            <div class="col mt-auto">
                                                                <button id="update_avatar_btn" type="submit"
                                                                    class="btn btn-primary btn-sm text-center">{{ __('Actualizar foto de perfil') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- user name-->
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input_name">{{ __('Nombre') }}</label>
                                                <input type="text" name="input_name" id="input_name"
                                                    class="form-control form-control-alternative"
                                                    value="{!! $patient->name !!}"
                                                    placeholder="{{ __('Ingresa el nombre') }}" autofocus>
                                            </div>
                                            <!-- user last_name-->
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input_last_name">{{ __('Apellidos') }}
                                                </label>
                                                <input type="text" name="input_name" id="input_last_name"
                                                    class="form-control form-control-alternative"
                                                    value="{!! $patient->last_name !!}"
                                                    placeholder="{{ __('Ingresa los apellidos') }}">
                                            </div>
                                            <!-- user email  -->
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-email">{{ __('Correo electrónico') }}
                                                    <span id="email_error" style="display:none;" class="text-red"><i
                                                            class="ni ni-fat-remove"></i></span>
                                                </label>
                                                <input type="email" name="input_email" id="input_email"
                                                    class="form-control form-control-alternative"
                                                    value="{!! $patient->email !!}"
                                                    placeholder="{{ __('Ingresa el correo electrónico') }}">
                                            </div>
                                            <!-- user password-->
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-password">{{ __('Contraseña') }}
                                                </label>
                                                <input type="password" name="input_password" id="input_password"
                                                    class="form-control form-control-alternative"
                                                    placeholder="{{ __('Ingresa la contraseña') }}">
                                            </div>
                                            <!-- user password confirmation -->
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input_password_confirmation">{{ __('Confirmar contraseña') }}
                                                </label>
                                                <input type="password" name="input_password_confirmation"
                                                    id="input_password_confirmation"
                                                    class="form-control form-control-alternative"
                                                    placeholder="{{ __('Ingresa la confirmación de la contraseña') }}">
                                            </div>
                                            <div class="text-muted font-italic">
                                                <small id="password_alert"
                                                    class="text-success font-weight-700">{{ __('La contraseña debe contener al menos 8 caracteres') }}
                                                    ({{ __('ingrese las contraseñas SOLO si desea cambiar la contraseña actual del usuario') }})</small>
                                                <small id="password_success" style="display: none"
                                                    class="text-success font-weight-700">{{ __('Las contraseñas coinciden') }}</small>
                                                <small id="password_mismatch" style="display: none"
                                                    class="text-warning font-weight-700">{{ __('Las contraseñas no coinciden') }}</small>
                                            </div>
                                            <!-- user CURP/ID -->
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-identificator">
                                                    {{ __('CURP') }}/{{ __('ID') }}
                                                    ({{ __('no es un campo obligatorio, pero si se desea ingresar debe ser válido') }})
                                                </label>
                                                <input type="text" data-toggle="tooltip" data-placement="top"
                                                    oninput="this.value = this.value.toUpperCase()"
                                                    name="input_identificator" id="input_identificator"
                                                    class="form-control form-control-alternative"
                                                    value="{!! $patient->identificator !!}"
                                                    placeholder="{{ __('Ingresa el') }} {{ __('CURP') }}/{{ __('ID') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <!--weight -->
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label class="form-control-label "
                                                                for="input_weight">{{ __('Peso') }}(kg.)</label>
                                                            <input type="number" name="input_weight" id="input_weight"
                                                                class="form-control form-control-alternative"
                                                                value="{!! $patient->weight !!}"
                                                                placeholder="{{ __('Peso') }}">
                                                        </div>
                                                    </div>
                                                    <!-- height -->
                                                    <div class="col">
                                                        <label class="form-control-label"
                                                            for="input_height">{{ __('Estatura') }}(cm.)</label>
                                                        <input type="number" name="input_height" id="input_height"
                                                            class="form-control form-control-alternative"
                                                            value="{!! $patient->height !!}"
                                                            placeholder="{{ __('Estatura') }}">
                                                    </div>
                                                    <!--birthdate -->
                                                    <div class="col">
                                                        <label class="form-control-label"
                                                            for="input_birthdate">{{ __('Fecha de nacimiento') }}</label>
                                                        <input type="date" name="input_birthdate" id="input_birthdate"
                                                            class="form-control form-control-alternative"
                                                            value="{!! $patient->birthdate !!}"
                                                            placeholder="{{ __('Fecha de nacimiento') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <!-- genre -->
                                                    <div class="col">
                                                        <label class="form-control-label"
                                                            for="input_genre">{{ __('Género') }}</label>
                                                        <select class="form-control select" name="input_genre"
                                                            id="select_genre">
                                                            @if ($patient->genre == 0)
                                                                <option value="0" selected>{{ __('Hombre') }}</option>
                                                                <option value="1">{{ __('Mujer') }}</option>
                                                            @elseif($patient->genre == 1)
                                                                <option value="0">{{ __('Hombre') }}</option>
                                                                <option value="1" selected>{{ __('Mujer') }}</option>
                                                            @else
                                                                <option value="-1" selected disabled>{{ __('Género') }}
                                                                </option>
                                                                <option value="0">{{ __('Hombre') }}</option>
                                                                <option value="1">{{ __('Mujer') }}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <!-- psychical activity -->
                                                    <div class="col">
                                                        <label class="form-control-label"
                                                            for="input_psychical_activity">{{ __('Actividad física') }}</label>
                                                        <select class="form-control select" name="input_psychical_activity"
                                                            id="select_psychical_activity">
                                                            @if ($patient->psychical_activity == 0)
                                                                <option selected value="0">{{ __('Reposo') }}</option>
                                                                <option value="1">{{ __('Ligera') }}</option>
                                                                <option value="2">{{ __('Moderada') }}</option>
                                                                <option value="3">{{ __('Intensa') }}</option>
                                                            @elseif($patient->psychical_activity == 1)
                                                                <option value="0">{{ __('Reposo') }}</option>
                                                                <option selected value="1">{{ __('Ligera') }}</option>
                                                                <option value="2">{{ __('Moderada') }}</option>
                                                                <option value="3">{{ __('Intensa') }}</option>
                                                            @elseif($patient->psychical_activity == 2)
                                                                <option value="0">{{ __('Reposo') }}</option>
                                                                <option value="1">{{ __('Ligera') }}</option>
                                                                <option selected value="2">{{ __('Moderada') }}</option>
                                                                <option value="3">{{ __('Intensa') }}</option>
                                                            @elseif($patient->psychical_activity == 3)
                                                                <option value="0">{{ __('Reposo') }}</option>
                                                                <option value="1">{{ __('Ligera') }}</option>
                                                                <option value="2">{{ __('Moderada') }}</option>
                                                                <option selected value="3">{{ __('Intensa') }}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            </div>

                                            <!-- caloric requirement -->
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="input-caloric-requirement">{{ __('Requerimiento calórico') }}</label>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="custom-radio-1" class="custom-control-input"
                                                                id="automatic_calculation" type="radio">
                                                            <label class="custom-control-label"
                                                                for="automatic_calculation">{{ __('Cálculo automático') }}
                                                                ({{ __('No requiere ingresar un valor') }})</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input name="custom-radio-1" class="custom-control-input"
                                                                id="custom_calculation" checked="" type="radio">
                                                            <label class="custom-control-label"
                                                                for="custom_calculation">{{ __('Personalizado') }}
                                                                ({{ __('Requiere ingresar un valor') }})</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="number" name="input_caloric_requirement"
                                                            id="input_caloric_requirement" data-toggle="tooltip"
                                                            data-placement="top" title="" value="{!! $patient->caloric_requirement !!}"
                                                            class="form-control form-control-alternative">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Anthropometric values -->
                                            <label class="text-info mb-2" id="required">
                                                {{ __('Valores antropométricos') }}
                                                ({{ __('no es un campo obligatorio, pero si se desea ingresar deben ser valores mayores que CERO') }})
                                            </label>
                                            <div class="form-group">
                                                <div class="row">
                                                    <!-- waist size -->
                                                    <div class="col">
                                                        <label class="form-control-label"
                                                            for="input_waist_size">{{ __('Tamaño de la cintura') }}(cm.)
                                                        </label>
                                                        <input type="number" name="input_waist_size" id="input_waist_size"
                                                            value="{!! $patient->waist_size !!}"
                                                            class="form-control form-control-alternative"
                                                            placeholder="{{ __('Tamaño de la cintura') }}">
                                                    </div>
                                                    <!-- size of the legs -->
                                                    <div class="col">
                                                        <label class="form-control-label"
                                                            for="input_legs_size">{{ __('Tamaño de las piernas') }}(cm.)
                                                        </label>
                                                        <input type="number" name="input_legs_size" id="input_legs_size"
                                                            class="form-control form-control-alternative"
                                                            value="{!! $patient->legs_size !!}"
                                                            placeholder="{{ __('Tamaño de las piernas') }}(cm.)">
                                                    </div>
                                                    <!-- wrist size -->
                                                    <div class="col">
                                                        <label class="form-control-label"
                                                            for="input_wrist_size">{{ __('Tamaño de las muñecas') }}(cm.)
                                                        </label>
                                                        <input type="number" name="input_wrist_size" id="input_wrist_size"
                                                            class="form-control form-control-alternative"
                                                            value="{!! $patient->wrist_size !!}"
                                                            placeholder="{{ __('Tamaño de las muñecas') }}">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('helpers.alerts')
                            <div class="text-center">
                                <button id="update_user_btn" type="submit"
                                    class="btn btn-success mt-4">{{ __('Actualizar usuario') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('js/user_update.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
