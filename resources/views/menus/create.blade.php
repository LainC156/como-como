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
        <input type="hidden" id="add_food_route" value="{{ route('food.add') }}" >
        <input type="hidden" id="list_food" value="{{ route('food.list') }}">
        <input type="hidden" id="list_menu" value="{{ route('menu.list', [$menu->id]) }}">
        <input type="hidden" id="edit_saved_menu" value="{{ route('menu.edit',[$patient->id, $menu->id]) }}">
        <input type="hidden" id="empty_menu_route" value="{{ route('empty.menu') }}">
        <input type="hidden" id="update_component_route" value="{{ route('component.update') }}">
        <input type="hidden" id="delete_component_route" value="{{ route('component.destroy') }}">
        <input type="hidden" id="time_0" value="{{ __('Desayuno') }}">
        <input type="hidden" id="time_1" value="{{ __('Colación matutina') }}">
        <input type="hidden" id="time_2" value="{{ __('Comida') }}">
        <input type="hidden" id="time_3" value="{{ __('Colación vespertina') }}">
        <input type="hidden" id="time_4" value="{{ __('Cena') }}">
        <input type="hidden" id="store_menu_route" value="{{ route('menu.store') }}">
        <input type="hidden" id="index_menu" value="{{ route('menu.index', [$patient->id]) }}">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="row">
                                    <input id="user_id" type="hidden" value="{{ $patient->id }}">
                                    <input id="menu_id" type="hidden" value="{{ $menu->id }}">
                                    <div class="col-auto">
                                        @if( $menu->kind_of_menu == 0 )
                                        <h5 class="mb-0 text-uppercase">{{ __('Menú nuevo') }}</h5>
                                        @else
                                        <h5 class="mb-0">{{ __('Nombre del menú') }}:
                                            <b class="text-primary text-uppercase">{!! $menu->name !!}</b>
                                        <h5 class="mb-0">{{ __('Descripción') }}:
                                            <b class="text-primary text-uppercase">{!! $menu->description !!}</b>
                                        @endif
                                        <h5 class="mb-0">{{ __('Paciente') }}:
                                            <b class="text-primary text-uppercase">{!! $patient->name !!} {!! $patient->last_name !!}</b>
                                        </h5>
                                        <h5 class="mb-0">{{ __('Requerimiento calórico') }}:
                                            <b class="text-primary text-uppercase"> {!! $patient->caloric_requirement !!} {{ __('calorías') }}</b>
                                        </h5>
                                    </div>
                                    <div class="col">
                                        @if( $required == 1 )
                                            <a id="btn_generate_results" class="btn btn-primary btn-outline-primary btn-sm" href="{{ route('menu.results', ['id' => $patient->id, 'menu_id' => $menu->id]) }}" target="_blank" ><i class="ni ni-chart-bar-32"></i>{{ __('Generar resultados') }}</a>
                                        @elseif( $required == 0 )
                                            <p class="description text-danger">{{ __('Este perfil no cuenta con los datos suficientes para realizar los cálculos correspondientes, da clic en ') }} {{ __('Actualizar perfil') }} {{ __('para actualizar los datos faltantes') }}. {{ __('Después de añadir los datos faltantes, vuelve aquí y actualiza la página') }}.</p>
                                            <a class="btn btn-warning btn-sm"data-toggle="tooltip" data-placement="top"
                                                title="{{ __('Para poder generar los resultados del paciente, se requiere: edad, peso, estatura, tipo de actividad física y requerimiento calórico del mismo') }}"
                                                href="{{ route('user.edit', [$patient->id] ) }}" ><i class="far fa-edit" aria-hidden="true"></i>{{ __('Actualizar perfil') }}</a>
                                        @endif
                                        @if( $menu->kind_of_menu == 0 )
                                        <a class="btn btn-success btn-outline-success btn-sm" id="btn_save_m" data-toggle="modal" data-target="#saveMenuModal"><i class="ni ni-folder-17" aria-hidden="true"></i>{{ __('Guardar menú') }} </a>
                                        @endif
                                        <a class="btn btn-warning btn-outline-warning btn-sm" id="btn_delete_m" data-toggle="modal" data-target="#deleteMenuModal"><i class="ni ni-fat-remove" aria-hidden="true"></i>{{ __('Limpiar menú') }}</a>
                                        <a class="btn btn-info btn-outline-info btn-sm" href="{{ route('menu.index',[ $patient->id ]) }}" target="_blank"><i class="ni ni-archive-2"></i>{{ __('Ver menús') }}</a>
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

    <!-- edit & delete component from menu modal -->
    @include('helpers.alerts')
    @include('helpers.editFoodFromMenu')
    @include('helpers.menus.saveMenu')
    @include('helpers.menus.deleteMenu')
    @include('layouts.footers.auth')

</div>
@endsection
@section("javascript")
    <script src="{{ asset('js/menus/create.js') }}"></script>

    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
