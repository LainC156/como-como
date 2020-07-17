@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Detalles del menú')])
<style>

</style>
    <div class="container-fluid mt--7">
        <input type="hidden" name="" id="menu_id" value="{!! $menu->id !!}">
        <input type="hidden" id="menu_type_1" value="{{ __('Menú propio') }}">
        <input type="hidden" id="menu_type_2" value="{{ __('Menú guardado desde otro usuario') }}">
        <input type="hidden" id="menu_type_3" value="{{ __('Menú modificado de otro usuario') }}">
        <input type="hidden" id="list_menu_route" value="{{ route('menu.list', $menu->id) }}">
        <input type="hidden" id="update_component_route" value="{{ route('component.update') }}">
        <input type="hidden" id="delete_component_route" value="{{ route('component.destroy') }}">
        <input type="hidden" id="save_menu_route" value="{{ route('menu.store') }}">
        <input type="hidden" id="time_0" value="{{ __('Desayuno') }}">
        <input type="hidden" id="time_1" value="{{ __('Colación matutina') }}">
        <input type="hidden" id="time_2" value="{{ __('Comida') }}">
        <input type="hidden" id="time_3" value="{{ __('Colación vespertina') }}">
        <input type="hidden" id="time_4" value="{{ __('Cena') }}">
        <input type="hidden" id="owner_id" value="{{ $patient->id }}">
        <input type="hidden" id="role_id" value="{{ $role_id }}">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-auto col-md-4">
                                <h5 class="mb-0">{{ __('Paciente') }}:
                                    <b class="text-primary text-uppercase">{!! $patient->name !!} {!! $patient->last_name !!}</b>
                                </h5>
                                <h5 class="mb-0">{{ __('Requerimiento calórico') }}:
                                    <b class="text-primary text-uppercase"> {!! $patient->caloric_requirement !!} {{ __('calorías') }}</b>
                                </h5>
                            </div>
                            <div class="col-auto col-md-4">
                                @if( $menu->name ==! '' && $menu->description ==! '' )
                                <h5 class="mb-0">{{ __('Nombre') }}:
                                    <b class="text-primary text-uppercase" > {!! $menu->name !!}</b>
                                </h5>
                                <h5 class="mb-0">{{ __('Descripción') }}:
                                    <b class="text-primary text-uppercase">{!! $menu->description !!}</b>
                                </h5>
                                @else
                                <h5 class="mb-0 text-uppercase text-primary">{{ __('Menú nuevo') }}
                                </h5>
                                @endif
                                <h5 class="mb-0">{{ __('Estado') }}:
                                    @if($menu->ideal == 0)
                                        <b class="text-red text-uppercase">{{ __('Menú deficiente') }} </b>
                                    @elseif($menu->ideal == 1)
                                        <b class="text-green text-uppercase">{{ __('Menú ideal') }} </b>
                                    @endif
                                </h5>
                            </div>
                            <div class="col-auto col-md-4">
                                @if( $menu_validation == 1 )
                                <a href="{{ route('menu.edit', ['id' => $menu->id]) }}" target="_blank" class="btn btn-sm btn-info"><i class="far fa-edit"></i> {{ __('Editar menú') }}</a>
                                @if($role_id == 2)
                                    <a data-toggle="modal" data-target="#saveMenuModal" class="btn btn-sm btn-success"><i class="ni ni-folder-17"></i> {{ __('Guardar menú') }}</a>
                                @endif
                                @else
                                <a data-toggle="modal" data-target="#saveMenuModal" class="btn btn-sm btn-success"><i class="ni ni-folder-17"></i> {{ __('Guardar menú') }}</a>
                                @endif
                                <a href="{{ route('menu.results', ['id' => $menu->id ]) }}" target="_blank" class="btn btn-sm btn-primary"><i class="ni ni-chart-bar-32"></i> {{ __('Generar resultados') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="error_alert" style="display:none;" class="alert alert-danger" role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span>
                            <strong>¡Error!:</strong>
                        </div>
                            <div id="success_alert" style="display:none;" class="alert alert-success" role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-check-bold"></i></span>
                            <strong>¡Listo!:</strong>
                        </div>
                    <!-- show all detail menu -->
                    <div class="table-responsive">
                            <table id="menu_table" class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Acciones') }}</th>
                                        <th scope="col">{{ __('Nombre') }}</th>
                                        <th scope="col">{{ __('Peso') }}</th>
                                        <th scope="col">{{ __('Tiempo') }}</th>
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
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header alert-success">
                        <h3 class="modal-title mb-0" id="exampleModalLabel">{{ __('Guardar menú') }}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <h5 class="text-center text-primary">{{ __('Propietario') }}: {!! $patient->name !!} {!! $patient->last_name !!}</h5>
                            <h5 class="text-muted">{{ __('Este menú pertenece a otro usuario, para poder usarlo, primero debes guardarlo') }}.</h5>
                            <h6 class="text-red text-muted">{{ __('Campos requeridos') }} *</h6>
                        </div>
                        <div class="col" >
                            <div class="form-group">
                                <label class="form-control-label" for="save_menu_name">{{ __('Nombre') }}
                                    <span id="name_required" style="color: red;">*</span>
                                    <span id="name_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                </label>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                    </div>
                                    <input type="text" id="menu_name" class="form-control" placeholder="{{ __('Nombre') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col" >
                            <div class="form-group">
                                <label class="form-control-label" for="save_menu_description">{{ __('Descripción') }}
                                    <span id="description_required" style="color: red;">*</span>
                                    <span id="description_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                                </label>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                    </div>
                                    <textarea type="text" id="menu_description" class="form-control" placeholder="{{ __('Descripción') }}" ></textarea>
                                </div>
                            </div>
                        </div>
                        @if( $role_id == 2 )
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-control-label" for="">{{ __('Selecciona el usuario a quien asignar el menú actual') }}
                                        <span id="select_required" style="color: red;">*</span>
                                        <span id="select_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span></label>
                                    <select id="patient_select" class="form-control">
                                        <option disabled selected>{{ __('Selecciona un paciente') }}</option>
                                        @forelse ($patients as $p)
                                            <option value="{!! $p->id !!}">{{ $p->name }} {{ $p->last_name }}</option>
                                        @empty
                                            <option disabled>{{ __('Sin opciones disponibles') }}</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div id="alert_section" class="alert alert-warning" style="display:none;" class="col">
                        </div>
                        <div class="col text-center">
                            <button id="save_menu_btn" class="btn btn-success" disabled><i class="ni ni-folder-17"></i> {{ __('Guardar') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('helpers.editFoodFromMenu')
        @include('layouts.footers.auth')
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/menus/show.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
