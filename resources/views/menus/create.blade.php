@extends('layouts.app', ['title' => __('User Management')])

@section('content')
        @include('foods.food_table')
    <style>
        #remove_data {
            color: #f00;
            text-shadow: 1px 1px 1px #ccc;
        }
        .popover {
            background-color: red;
        }
    </style>
    <div class="container-fluid mt--7">
        <input type="hidden" id="patient_id" value="{!! $patient->id !!}">
        <input type="hidden" id="kind_of_menu" value="{!! $menu->kind_of_menu !!}">
        <input type="hidden" id="add_food_route" value="{{ route('add.food') }}" >
        <input type="hidden" id="list_food" value="{{ route('list.food') }}">
        <input type="hidden" id="update_food" value="{{ route('update.food') }}">
        <input type="hidden" id="list_menu" value="{{ route('list.menu', [$patient->id]) }}">
        <input type="hidden" id="edit_saved_menu" value="{{ route('edit.menu',[$patient->id, $menu->id]) }}">
        <input type="hidden" id="time_0" value="{{ __('Desayuno') }}">
        <input type="hidden" id="time_1" value="{{ __('Colación matutina') }}">
        <input type="hidden" id="time_2" value="{{ __('Comida') }}">
        <input type="hidden" id="time_3" value="{{ __('Colación vespertina') }}">
        <input type="hidden" id="time_4" value="{{ __('Cena') }}">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="row">
                                    <input id="user_id" type="hidden" value="{{ $patient->id }}">
                                    <input id="menu_id" type="hidden" value="{{ $menu->id }}">
                                    <div class="col-4">
                                        @if( $menu->kind_of_menu == 0 )
                                        <h5 class="mb-0 text-uppercase">{{ __('Menú nuevo') }}</h5>
                                        @else
                                        <h5 class="mb-0">{{ __('Nombre del menú') }}:
                                            <b class="text-primary text-uppercase">{!! $menu->name !!}</b>
                                        <h5 class="mb-0">{{ __('Descripción') }}:
                                            <b class="text-primary text-uppercase">{!! $menu->description !!}</b>
                                        @endif
                                        <h5 class="mb-0">{{ __('Paciente') }}:
                                            <b class="text-primary text-uppercase">{!! $patient->name !!}</b>
                                        </h5>
                                        <h5 class="mb-0">{{ __('Requerimiento calórico') }}:
                                            <b class="text-primary text-uppercase"> {!! $patient->caloric_requirement !!} {{ __('calorías') }}</b>
                                        </h5>
                                    </div>
                                    <div class="col-8">
                                        @if( $required == 1 )
                                            <a id="btn_generate_results" class="btn btn-primary btn-outline-primary" href="{{ route('results.menu', ['id' => $patient->id, 'menu_id' => $menu->id]) }}" target="_blank" >{{ __('Generar resultados') }}</a>
                                        @elseif( $required == 0 )
                                            <p class="description text-danger">{{ __('Este perfil no cuenta con los datos suficientes para realizar los cálculos correspondientes, da clic en ') }} {{ __('Actualizar perfil') }} {{ __('para actualizar los datos faltantes') }}. {{ __('Después de añadir los datos faltantes, vuelve aquí y actualiza la página') }}.</p>
                                            <a class="btn btn-warning"data-toggle="tooltip" data-placement="top"
                                                title="{{ __('Para poder generar los resultados del paciente, se requiere: edad, peso, estatura, tipo de actividad física y requerimiento calórico del mismo') }}"
                                                href="{{ route('user.edit', [$patient->id] ) }}" >{{ __('Actualizar perfil') }}</a>
                                        @endif
                                        @if( $menu->kind_of_menu == 0 )
                                        <a class="btn btn-success btn-outline-success" id="btn_save_m" data-toggle="modal" data-target="#saveMenuModal">{{ __('Guardar menú') }} </a>
                                        @endif
                                        <a class="btn btn-warning btn-outline-warning" id="btn_delete_m"data-toggle="modal" data-target="#deleteMenuModal">{{ __('Limpiar menú') }}</a>
                                        <a class="btn btn-info btn-outline-info" href="{{ route('index.menu',[ $patient->id ]) }}" target="_blank">{{ __('Ver menús') }}</a>
                                    </div>
                                </div>
                                <div class="alert alert-danger" style="display: none" role="alert" id="alert_error">
                                    <span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span>
                                </div>
                                <div class="alert alert-success" style="display: none" role="alert" id="alert_success">
                                    <span><i class="ni ni-check-bold"></i></span>
                                </div>
                            </div>
                            <!--
                            @if(!$required)
                                <div class="col-4 text-right">
                                    <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">{{ __('Añadir usuario') }}</a>
                                </div>
                            @endif -->
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="menu_table" class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Editar') }}</th>
                                    <th scope="col">{{ __('Tiempo') }}</th>
                                    <th scope="col">{{ __('Peso') }}</th>
                                    <th scope="col">{{ __('Nombre') }}</th>
                                    <th scope="col">{{ __('KCAL') }}</th>
                                    <th scope="col">{{ __('KJ') }}</th>
                                    <th scope="col">{{ __('Agua') }}</th>
                                    <th scope="col">{{ __('Fibra dietética') }}</th>
                                    <th scope="col">{{ __('Carbohidratos') }}</th>
                                    <th scope="col">{{ __('Proteínas') }}</th>
                                    <th scope="col">{{ __('Lípidos totales') }}</th>
                                    <th scope="col">{{ __('Lípidos saturados') }}</th>
                                    <th scope="col">{{ __('Lípidos monosaturados') }}</th>
                                    <th scope="col">{{ __('Lípidos polisaturados') }}</th>
                                    <th scope="col">{{ __('Colesterol') }}</th>
                                    <th scope="col">{{ __('Calcio') }}</th>
                                    <th scope="col">{{ __('Fósforo') }}</th>
                                    <th scope="col">{{ __('Hierro') }}</th>
                                    <th scope="col">{{ __('Magnesio') }}</th>
                                    <th scope="col">{{ __('Sodio') }}</th>
                                    <th scope="col">{{ __('Potasio') }}</th>
                                    <th scope="col">{{ __('Zinc') }}</th>
                                    <th scope="col">{{ __('Vitamina A') }}</th>
                                    <th scope="col">{{ __('Ácido ascórbico') }}</th>
                                    <th scope="col">{{ __('Tiamina') }}</th>
                                    <th scope="col">{{ __('Riboflavina') }}</th>
                                    <th scope="col">{{ __('Niacina') }}</th>
                                    <th scope="col">{{ __('Piridoxina') }}</th>
                                    <th scope="col">{{ __('Ácido fólico') }}</th>
                                    <th scope="col">{{ __('Cobalamina') }}</th>
                                    <th scope="col">{{ __('Porcentaje comestible') }}</th>
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
        <!-- save menu modal -->
    <div class="modal fade" id="saveMenuModal" tabindex="-1" role="dialog" aria-labelledby="saveMenuModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header alert-success">
                    <h3 class="modal-title mb-0" id="exampleModalLabel">{{ __('Guardar menú') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col" >
                        <div class="form-group">
                            <label class="form-control-label" for="save_menu_name">{{ __('Nombre') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                </div>
                                <input type="text" id="menu_name" name="save_new_menu_name" class="form-control" placeholder="{{ __('Nombre') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col" >
                        <div class="form-group">
                            <label class="form-control-label" for="save_menu_description">{{ __('Descripción') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                </div>
                                <textarea type="text" id="menu_description"name="save_new_menu_description" class="form-control" placeholder="{{ __('Descripción') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col alert alert-success">
                        <p class="text-black">{{ __('Esta ventana se cerrará al guargar el menú, para ver el menú guardado, ve a los perfiles de los usuarios y selecciona') }} {{ __('Ver menús') }}</p>
                    </div>
                    <div class="col">
                        <input type="button" id="btn_save_menu" type="button" data-container="body" data-color="default" data-toggle="popover" data-placement="bottom" class="btn btn-success btn-block" value="{{ __('Guardar') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- delete menu modal -->
    <div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header  alert alert-warning">
                    <h3 class="modal-title mb-0" id="exampleModalLabel">{{ __('Borrar menú') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="alert alert-warning">{{ __('Esta acción no puede deshacerse, ¿estás seguro?') }}</p>
                    <div class="col">
                        <input type="button" id="btn_delete_menu" class="btn btn-warning" value="{{ __('Aceptar') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit & delete component from menu modal -->
    @include('helpers.alerts')
    @include('helpers.editFoodFromMenu')
    @include('layouts.footers.auth')
@endsection
@section("javascript")
    <script src="{{ asset('js/menus/create.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
