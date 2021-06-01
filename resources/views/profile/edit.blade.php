@extends('layouts.app')
@section('title')
    {{ __('Editar perfil') }} | {{ __('¿Cómo como?') }}
@endsection
@section('content')
    @include('users.partials.header', [
    'title' => __('Editar perfil'),
    'description' => __('This is your profile page. You can see the progress you\'ve made with your work and manage your
    projects or assigned tasks'),
    'class' => 'col-lg-12'
    ])

    <div class="container-fluid mt--7">
        <input type="hidden" id="user_id" value="{{ $user->id }}">
        <input id="user_update_route" type="hidden" value="{{ route('user.update') }}">
        <input id="update_nutritionist_route" type="hidden" value="{{ route('profile.update') }}">
        <input id="home_route" type="hidden" value="{{ route('home') }}">
        <input type="hidden" id="update_avatar_route" value="{{ route('avatar.update', $user->id) }}">
        <div class="row">
            <div class="col">
                <div class="card bg-secondary  shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="{{ asset('img/avatar/' . $user->avatar) }}" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <h6 class="col-12 mb-0">{{ __('Campos requeridos') }} <span style="color: red">*</span>
                        </h6>
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
                            <div class="col">
                                @include('helpers.alerts')
                            </div>
                        </div>
                        <!-- USER PROFILE AVATAR -->
                        <div class="row">
                            <div class="col">
                                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data"
                                    id="upload_avatar">
                                    <input id="img_avatar" class="btn btn-sm btn-info mr-4" name="avatar" type="file"
                                        class="form-control" accept="image/*">
                                    <button id="update_avatar_btn" type="submit"
                                        class="btn btn-sm btn-default float-right">{{ __('Actualizar avatar') }}</button>
                                </form>
                            </div>
                            <div class="col">
                                <!-- user name-->
                                <div class="form-group">
                                    <label class="form-control-label" for="input_name">{{ __('Nombre') }}
                                        <span id="name_required" style="color: red;">*</span>
                                    </label>
                                    <input type="text" name="input_name" id="input_name"
                                        class="form-control form-control-alternative capitalize"
                                        value="{{ $user->name }}" placeholder="{{ __('Nombre') }}" autofocus>
                                </div>
                            </div>
                            <div class="col">
                                <!-- user last_name-->
                                <div class="form-group">
                                    <label class="form-control-label" for="input_last_name">{{ __('Apellidos') }}
                                        <span id="last_name_required" style="color: red;">*</span>
                                    </label>
                                    <input type="text" name="input_name" id="input_last_name"
                                        class="form-control form-control-alternative" value="{{ $user->last_name }}"
                                        placeholder="{{ __('Apellidos') }}">
                                </div>
                            </div>
                            <div class="col">
                                <!-- user email  -->
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Correo electrónico') }}
                                        <span id="email_required" style="color: red;">*</span>
                                    </label>
                                    <input type="email" name="input_email" id="input_email"
                                        class="form-control form-control-alternative" value="{{ $user->email }}"
                                        placeholder="{{ __('Correo electrónico') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <!-- user CURP/ID -->
                                <div class="form-group">
                                    <label class="form-control-label" for="input-identificator">
                                        {{ __('CURP') }}/{{ __('ID') }}
                                    </label>
                                    <input type="text" data-toggle="tooltip" data-placement="top"
                                        oninput="this.value = this.value.toUpperCase()" name="input_identificator"
                                        id="input_identificator" class="form-control form-control-alternative"
                                        value="{{ $user->identificator }}"
                                        placeholder="{{ __('CURP') }}/{{ __('ID') }}">

                                </div>
                            </div>
                            <div class="col">
                                <!-- user password-->
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password">{{ __('Contraseña') }}
                                    </label>
                                    <input type="password" name="input_password" id="input_password"
                                        class="form-control form-control-alternative"
                                        placeholder="{{ __('Contraseña') }}">
                                </div>
                            </div>
                            <div class="col">
                                <!-- user password confirmation -->
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="input_password_confirmation">{{ __('Confirmar contraseña') }}
                                    </label>
                                    <input type="password" name="input_password_confirmation"
                                        id="input_password_confirmation" class="form-control form-control-alternative"
                                        placeholder="{{ __('Confirmar contraseña') }}" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="text-muted font-italic">
                                        <small id="password_alert"
                                            class="text-success font-weight-700">{{ __('La contraseña debe contener al menos 8 caracteres') }}
                                            ({{ __('ingrese las contraseñas SOLAMENTE si desea cambiar la contraseña actual del usuario') }})</small>
                                        <small id="password_success" style="display: none"
                                            class="text-success font-weight-700">{{ __('Las contraseñas coinciden') }}</small>
                                        <small id="password_mismatch" style="display: none"
                                            class="text-warning font-weight-700">{{ __('Las contraseñas no coinciden') }}</small>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-control-label text-info" for="input-identificator">
                                        {{ __('CURP') }}/{{ __('ID') }}
                                        ({{ __('no es un campo obligatorio, pero si se desea ingresar debe ser válido') }})
                                    </label>
                                </div>
                                @if ($role_id == 2)
                                    <div class="col">
                                        <div class="card-profile-stats justify-content-center">
                                            <div>
                                                <span class="heading">{!! $total_patients !!}</span>
                                                <span class="description">{{ __('Paciente') }}(s)</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if ($role_id == 2)
                            <!-- this button only update nutritionist profile -->
                            <div class="row">
                                <div class="col">
                                    <div class="card-footer">
                                        <button id="loader" class="btn btn-success btn-sm" hidden>
                                            <span class="spinner-border spinner-border"></span>
                                            {{ __('Procesando') }}...
                                        </button>
                                        <button class="btn btn-success btn-block" id="update_nutritionist_btn"><i
                                                class="fa fa-user-plus"></i>{{ __('Actualizar perfil') }}</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if ($role_id == 3)
                <div class="col">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="pl-lg-4">
                                <div class="row">
                                    <!--weight -->
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-control-label "
                                                for="input_weight">{{ __('Peso') }}(kg.)</label>
                                            <span id="weight_required" style="display:none" class="text-red">*</span>
                                            <input type="number" name="input_weight" id="input_weight"
                                                class="form-control form-control-alternative" value="{{ $user->weight }}"
                                                placeholder="{{ __('Peso') }}">
                                        </div>
                                    </div>
                                    <!-- height -->
                                    <div class="col">
                                        <label class="form-control-label"
                                            for="input_height">{{ __('Estatura') }}(cm.)</label>
                                        <span id="height_required" style="display:none" class="text-red">*</span>
                                        <input type="number" name="input_height" id="input_height"
                                            class="form-control form-control-alternative" value="{{ $user->height }}"
                                            placeholder="{{ __('Estatura') }}">
                                    </div>
                                    <!--birthdate -->
                                    <div class="col">
                                        <label class="form-control-label"
                                            for="input_birthdate">{{ __('Fecha de nacimiento') }}</label>
                                        <span id="birthdate_required" style="display: none" class="text-red">*</span>
                                        <input type="date" name="input_birthdate" id="input_birthdate"
                                            class="form-control form-control-alternative" value="{{ $user->birthdate }}"
                                            placeholder="{{ __('Fecha de nacimiento') }}">
                                    </div>

                                </div>
                                <div class="row">
                                    <!-- genre -->
                                    <div class="col">
                                        <label class="form-control-label" for="input_genre">{{ __('Género') }}</label>
                                        <span id="genre_required" style="display: none" class="text-red">*</span>
                                        <select class="form-control select" name="input_genre" id="select_genre">
                                            @if ($user->genre == 0)
                                                <option value="-1" disabled>{{ __('Género') }}</option>
                                                <option value="0" selected>{{ __('Hombre') }}</option>
                                                <option value="1">{{ __('Mujer') }}</option>
                                            @elseif($user->genre == 1)
                                                <option value="-1" disabled>{{ __('Género') }}</option>
                                                <option value="0">{{ __('Hombre') }}</option>
                                                <option value="1" selected>{{ __('Mujer') }}</option>
                                            @else
                                                <option value="-1" selected disabled>{{ __('Género') }}</option>
                                                <option value="0">{{ __('Hombre') }}</option>
                                                <option value="1">{{ __('Mujer') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <!-- psychical activity -->
                                    <div class="col">
                                        <label class="form-control-label"
                                            for="input_psychical_activity">{{ __('Actividad física') }}</label>
                                        <span id="psychical_activity_required" style="display: none"
                                            class="text-red">*</span>
                                        <select class="form-control select" name="input_psychical_activity"
                                            id="select_psychical_activity">
                                            @if ($user->psychical_activity == 0)
                                                <option value="-1" disabled>{{ __('Actividad física') }}</option>
                                                <option value="0" selected>{{ __('Reposo') }}</option>
                                                <option value="1">{{ __('Ligera') }}</option>
                                                <option value="2">{{ __('Moderada') }}</option>
                                                <option value="3">{{ __('Intensa') }}</option>
                                            @elseif($user->psychical_activity == 1)
                                                <option value="-1" disabled>{{ __('Actividad física') }}</option>
                                                <option value="0">{{ __('Reposo') }}</option>
                                                <option value="1" selected>{{ __('Ligera') }}</option>
                                                <option value="2">{{ __('Moderada') }}</option>
                                                <option value="3">{{ __('Intensa') }}</option>
                                            @elseif($user->psychical_activity == 2)
                                                <option value="-1" disabled>{{ __('Actividad física') }}</option>
                                                <option value="0">{{ __('Reposo') }}</option>
                                                <option value="1">{{ __('Ligera') }}</option>
                                                <option value="2" selected>{{ __('Moderada') }}</option>
                                                <option value="3">{{ __('Intensa') }}</option>
                                            @elseif($user->psychical_activity == 3)
                                                <option value="-1" disabled>{{ __('Actividad física') }}</option>
                                                <option value="0">{{ __('Reposo') }}</option>
                                                <option value="1">{{ __('Ligera') }}</option>
                                                <option value="2">{{ __('Moderada') }}</option>
                                                <option value="3" selected>{{ __('Intensa') }}</option>
                                            @else
                                                <option value="-1" selected disabled>{{ __('Actividad física') }}
                                                </option>
                                                <option value="0">{{ __('Reposo') }}</option>
                                                <option value="1">{{ __('Ligera') }}</option>
                                                <option value="2">{{ __('Moderada') }}</option>
                                                <option value="3">{{ __('Intensa') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <!-- caloric requirement -->
                                        <label class="form-control-label"
                                            for="input-caloric-requirement">{{ __('Requerimiento calórico') }}</label>
                                        <span id="caloric_requirement_required" class="text-red">*</span>
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="custom-control custom-radio mb-3">
                                                    <input name="custom-radio-1" class="custom-control-input"
                                                        id="automatic_calculation" type="radio" @if ($user->acrc) checked @endif>
                                                    <label class="custom-control-label"
                                                        for="automatic_calculation">{{ __('Cálculo automático') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="custom-control custom-radio mb-3">
                                                    <input name="custom-radio-1" class="custom-control-input"
                                                        id="custom_calculation" type="radio" @if (!$user->acrc) checked @endif>
                                                    <label class="custom-control-label"
                                                        for="custom_calculation">{{ __('Personalizado') }}</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <input type="number" name="input_caloric_requirement"
                                                    id="input_caloric_requirement" data-toggle="tooltip"
                                                    data-placement="top" placeholder="{{ __('Requerimiento calórico') }}"
                                                    value="{{ $user->caloric_requirement }}"
                                                    class="form-control form-control-alternative text-center">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr class="my-4">
                                <h6 class="heading-small  mb-4" id="required">{{ __('Valores antropométricos') }}</h6>
                                <div class="row">
                                    <!--Anthropometric values -->
                                    <!-- waist size -->
                                    <div class="col">
                                        <label class="form-control-label"
                                            for="input_waist_size">{{ __('Tamaño de la cintura') }}
                                            (cm.)
                                        </label>
                                        <input type="number" name="input_waist_size" id="input_waist_size"
                                            class="form-control form-control-alternative" value="{{ $user->waist_size }}"
                                            placeholder="{{ __('Tamaño de la cintura') }}">
                                    </div>
                                    <!-- size of the legs -->
                                    <div class="col">
                                        <label class="form-control-label"
                                            for="input_legs_size">{{ __('Tamaño de las piernas') }}
                                            (cm.)
                                        </label>
                                        <input type="number" name="input_legs_size" id="input_legs_size"
                                            class="form-control form-control-alternative" value="{{ $user->legs_size }}"
                                            placeholder="{{ __('Tamaño de las piernas') }}(cm.)">
                                    </div>
                                    <!-- wrist size -->
                                    <div class="col">
                                        <label class="form-control-label"
                                            for="input_wrist_size">{{ __('Tamaño de las muñecas') }} (cm.)
                                        </label>
                                        <input type="number" name="input_wrist_size" id="input_wrist_size"
                                            class="form-control form-control-alternative" value="{{ $user->wrist_size }}"
                                            placeholder="{{ __('Tamaño de las muñecas') }}">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card body-->
                        <div class="card-footer">
                            <button id="loader" class="btn btn-success btn-sm" hidden>
                                <span class="spinner-border spinner-border"></span>
                                {{ __('Procesando') }}...
                            </button>
                            <button class="btn btn-success btn-block" id="update_user_btn"><i
                                    class="fa fa-user-plus"></i>{{ __('Actualizar perfil') }}</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @include('layouts.footers.auth')
    </div>

@endsection
@section('javascript')
    <script src="{{ asset('js/profile/edit.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
