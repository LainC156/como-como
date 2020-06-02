@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Editar datos del paciente')])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <h3 class="mb-0 text-red">{{ __('Campos obligatorios') }} *</h3>
                            </div>
                            <div class="col-auto">

                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary" target="_blank">{{ __('Pacientes registrados') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <input id="user_update_route" type="hidden" value="{{ route('user.update') }}">
                        <input id="home_route" type="hidden" value="{{ route('home') }}">
                        <input type="hidden" id="update_avatar_route" value="{{ route('avatar.update',$patient->user_id) }}">
                        <input type="hidden" value="{!! $patient->id !!}" id="patient_id">
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col col-xl-5">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="upload_avatar">
                                                    <div class="form-group text-center">
                                                        <!-- <label for="img_image">{{ __('Actualizar foto de perfil') }}</label> -->
                                                            <img class="responsive text-center" style="vertical-align: middle;width: 150px;height: 150px;border-radius: 50%;" src="{{ asset('img/avatar/'.$patient->avatar) }}" alt="no_img">
                                                        <input id="img_avatar" name="avatar" type="file" class="form-control" accept="image/*">
                                                        <button id="update_avatar_btn" type="submit" class="btn btn-primary text-center">{{ __('Actualizar foto de perfil') }}</button>
                                                    </div>
                                                </form>

                                                <!-- user name-->
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input_name">{{ __('Nombre') }}
                                                        <span id="name_required" style="color: red;display:none;">*</span>
                                                        <span id="name_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                    </label>
                                                    <input type="text" name="input_name" id="input_name" class="form-control form-control-alternative capitalize" value="{!! $patient->name !!}" placeholder="{{ __('Nombre') }}" autofocus>
                                                </div>
                                                <!-- user last_name-->
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input_last_name">{{ __('Apellidos') }}
                                                        <span id="last_name_required" style="color: red;display:none;">*</span>
                                                        <span id="last_name_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                    </label>
                                                    <input type="text" name="input_name" id="input_last_name" class="form-control form-control-alternative" value="{!! $patient->last_name !!}" placeholder="{{ __('Nombre') }}">
                                                </div>
                                                <!-- user email  -->
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-email">{{ __('Correo electrónico') }}
                                                        <span id="email_required" style="color: red;display:none;">*</span>
                                                        <span id="email_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                        <span id="email_error" style="display:none;" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                    </label>
                                                    <input type="email" name="input_email" id="input_email" class="form-control form-control-alternative" value="{!! $patient->email !!}" placeholder="{{ __('Correo electrónico') }}" >
                                                </div>
                                                <!-- user password-->
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-password">{{ __('Contraseña') }}
                                                        <span id="password_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                        <span id="password_error" style="display:none;" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                    </label>
                                                    <input type="password" name="input_password" id="input_password" class="form-control form-control-alternative" placeholder="{{ __('Contraseña') }}">
                                                </div>
                                                <!-- user password confirmation -->
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input_password_confirmation">{{ __('Confirmar contraseña') }}
                                                        <span id="password_confirmation_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                        <span id="password_confirmation_error" style="display:none;" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                    </label>
                                                    <input type="password" name="input_password_confirmation" id="input_password_confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirmar contraseña') }}" >
                                                </div>
                                                <div class="text-muted font-italic">
                                                    <small id="password_alert" class="text-success font-weight-700">{{ __('La contraseña debe de ser de al menos 8 caracteres') }}</small>
                                                    <small id="password_success"  style="display: none" class="text-success font-weight-700">{{ __('Las contraseñas coinciden') }}</small>
                                                    <small id="password_mismatch" style="display: none" class="text-warning font-weight-700">{{ __('Las contraseñas no coinciden') }}</small>
                                                </div>
                                                <!-- user CURP/ID -->
                                                <div class="form-group">
                                                    <label class="form-control-label" for="input-identificator" >
                                                        {{ __('CURP') }}/{{ __('ID') }}
                                                        <span id="identificator_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                        <span id="identificator_error" style="display:none;" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                    </label>
                                                    <input type="text" data-toggle="tooltip" data-placement="top"
                                                    oninput="this.value = this.value.toUpperCase()"
                                                    name="input_identificator" id="input_identificator" class="form-control form-control-alternative" value="{!! $patient->identificator !!}" placeholder="{{ __('CURP') }}/{{ __('ID') }}">

                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                    <div class="col col-xl-7">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <!--weight -->
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label class="form-control-label " for="input_weight">{{__('Peso')}}(kg.)</label>
                                                                <span id="weight_required" style="display:none" class="text-red">*</span>
                                                                <span id="weight_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                                <span id="weight_error" style="display:none;" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                                <input type="number" name="input_weight" id="input_weight" class="form-control form-control-alternative" value="{!! $patient->weight !!}" placeholder="{{ __('Peso') }}">
                                                            </div>
                                                        </div>
                                                         <!-- height -->
                                                        <div class="col">
                                                            <label class="form-control-label" for="input_height">{{ __('Estatura') }}(cm.)</label>
                                                            <span id="height_required" style="display:none" class="text-red">*</span>
                                                            <span id="height_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                            <span id="height_error" style="display:none;" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                            <input type="number" name="input_height" id="input_height" class="form-control form-control-alternative" value="{!! $patient->height !!}" placeholder="{{ __('Estatura') }}">
                                                        </div>
                                                        <!--birthdate -->
                                                        <div class="col">
                                                            <label class="form-control-label" for="input_birthdate">{{ __('Fecha de nacimiento') }}</label>
                                                            <span id="birthdate_required" style="display:none" class="text-red">*</span>
                                                            <span id="birthdate_check" style="display:none" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                            <span id="birthdate_error" style="display:none" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                            <input type="date" name="input_birthdate" id="input_birthdate" class="form-control form-control-alternative" value="{!! $patient->birthdate !!}" placeholder="{{ __('Fecha de nacimiento') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <!-- genre -->
                                                        <div class="col">
                                                            <label class="form-control-label" for="input_genre">{{ __('Género') }}</label>
                                                            <span id="genre_required" style="display:none" class="text-red">*</span>
                                                            <span id="genre_check" style="display:none" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                            <span id="genre_error" style="display:none" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                            <select class="form-control select" name="input_genre" id="select_genre">
                                                                @if($patient->genre == 0)
                                                                    <option value="0" selected>{{ __('Hombre') }}</option>
                                                                    <option value="1">{{ __('Mujer') }}</option>
                                                                @elseif($patient->genre == 1)
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
                                                            <label class="form-control-label" for="input_psychical_activity">{{ __('Actividad física') }}</label>
                                                            <span id="psychical_activity_required" style="display:none" class="text-red">*</span>
                                                            <span id="psychical_activity_check" style="display:none" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                            <span id="psychical_activity_error" style="display:none" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                            <select class="form-control select" name="input_psychical_activity" id="select_psychical_activity">
                                                                @if($patient->psychical_activity == 0)
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
                                                    <label class="form-control-label" for="input-caloric-requirement">{{ __('Requerimiento calórico') }}</label>
                                                    <span id="caloric_requirement_required" class="text-red">*</span>
                                                    <span id="caloric_requirement_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                    <span id="caloric_requirement_error" style="display:none;" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="custom-control custom-radio mb-3">
                                                                <input name="custom-radio-1" class="custom-control-input" id="automatic_calculation" type="radio">
                                                                <label class="custom-control-label" for="automatic_calculation">{{ __('Cálculo automático') }}</label>
                                                              </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="custom-control custom-radio mb-3">
                                                                <input name="custom-radio-1" class="custom-control-input" id="custom_calculation" checked="" type="radio">
                                                                <label class="custom-control-label" for="custom_calculation">{{ __('Personalizado') }}</label>
                                                              </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="number" name="input_caloric_requirement" id="input_caloric_requirement"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title=""
                                                            value="{!! $patient->caloric_requirement !!}" class="form-control form-control-alternative">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Anthropometric values -->
                                                <h6 class="heading-small  mb-4" id="required">{{ __('Valores antropométricos') }}</h6>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <!-- waist size -->
                                                        <div class="col">
                                                            <label class="form-control-label" for="input_waist_size">{{ __('Tamaño de la cintura') }}(cm.)
                                                                <span id="waist_size_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                                <span id="waist_size_error" style="display:none;" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                            </label>
                                                            <input type="number" name="input_waist_size" id="input_waist_size"  value="{!! $patient->waist_size !!}" class="form-control form-control-alternative" placeholder="{{ __('Tamaño de la cintura') }}">
                                                        </div>
                                                        <!-- size of the legs -->
                                                        <div class="col">
                                                            <label class="form-control-label" for="input_legs_size">{{ __('Tamaño de las piernas') }}(cm.)
                                                                <span id="legs_size_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                                <span id="legs_size_error" style="display:none;" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                            </label>
                                                            <input type="number" name="input_legs_size" id="input_legs_size" class="form-control form-control-alternative" value="{!! $patient->legs_size !!}" placeholder="{{ __('Tamaño de las piernas') }}(cm.)">
                                                        </div>
                                                        <!-- wrist size -->
                                                        <div class="col">
                                                            <label class="form-control-label" for="input_wrist_size">{{ __('Tamaño de las muñecas') }}(cm.)
                                                                <span id="wrist_size_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                                                <span id="wrist_size_error" style="display:none;" class="text-red"><i class="ni ni-fat-remove"></i></span>
                                                            </label>
                                                            <input type="number" name="input_wrist_size" id="input_wrist_size" class="form-control form-control-alternative" value="{!! $patient->wrist_size !!}" placeholder="{{ __('Tamaño de las muñecas') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>



                                @include('helpers.alerts')
                                <div class="text-center">
                                    <button id="update_user_btn" type="submit" class="btn btn-success mt-4">{{ __('Actualizar usuario') }}</button>
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
