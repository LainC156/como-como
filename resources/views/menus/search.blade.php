@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Búsqueda en menús')])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="form text-center" action="{{ route('menu.searchresults') }}" autocomplete="off">
                            @csrf
                            <div id="search_form_group" class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span  id="search_success_span" class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" id="search_success_input"
                                        data-toggle="tooltip" data-placement="top"
                                            title="{{ __('¿Qué estás buscando?') }}"
                                        name="search_menu" class="form-control" placeholder="{{ __('Buscar en menús') }}" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if( isset($names) || null ==! ($patients ?? '' ?? '') || isset($foods) || isset($menusByName)|| isset($menusByDescription) )
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                            </div>
                            <div class="col-4 text-right">
                                <!-- <a href="" class="btn btn-sm btn-primary">{{ __('Alguna opción') }}</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fa fa-users mr-2"></i>{{ __('Usuarios') }}</a>
                                </li>
                                @if( $role_id == 2 )
                                <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="true"><i class="fa fa-users mr-2"></i>{{ __('Pacientes') }}</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false"><i class="fas fa-utensils mr-2"></i>{{ __('Alimentos en menú') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>{{ __('Menús por nombre') }}</a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-5-tab" data-toggle="tab" href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5" aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>{{ __('Menús por descripción') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                        <div class="row">
                                            <div class="card-columns">
                                            @forelse( $usernames as $u)
                                                <div class="card card-sm border-primary bg-secondary mb-3">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <span class="avatar avatar rounded-circle">
                                                                        <img alt="Image placeholder" src="{{ asset('img/avatar/'.$u->avatar) }}">
                                                                </span>
                                                            </div>
                                                            <div class="col-9">
                                                                <h3 class="card-title text-primary">{!! $u->name !!} {!! $u->last_name !!}</h3>
                                                                <h6 class="text-muted">{{ __('Fecha de creación') }}: {!! $u->created_at !!}. {{ __('Última actualización') }}: {!! $u->updated_at !!}.</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <p class="description">{{ __('Edad') }}: <strong class="text-primary">{!! $u->age !!} {{ __('años') }}</strong></p>
                                                            </div>
                                                            <div class="col-auto">
                                                            @if( $u ->genre == 0)
                                                                <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Hombre') }}</strong></p>
                                                            @else
                                                                <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Mujer') }}</strong></p>
                                                            @endif
                                                            </div>
                                                            <div class="col-auto">
                                                                <p class="description">{{ __('Requerimiento calórico') }}: <strong class="text-primary">{!! $u->caloric_requirement !!} {{ __('kcal') }}.</strong></p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <p class="description">{{ __('Peso') }}: <strong class="text-primary">{!! $u->weight !!} {{ __('kg') }}.</strong></p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <p class="description">{{ __('Estatura') }}: <strong class="text-primary">{!! $u->height !!} {{ __('cm') }}.</strong></p>
                                                            </div>
                                                            <div class="col-auto">
                                                            @if( $u->psychical_activity == 0 )
                                                                <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Reposo') }}</strong></p>
                                                            @elseif( $u->psychical_activity == 1 )
                                                                <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Ligera') }}</strong></p>
                                                            @elseif( $u->psychical_activity == 2 )
                                                                <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Moderada') }}</strong></p>
                                                            @elseif( $u->psychical_activity == 3 )
                                                                <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Intensa') }}</strong></p>
                                                            @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <a class="btn btn-primary btn-sm btn-block" href="{{ route('menu.index', [$u->user_id] )}}" target="_blank"><i class="fas fa-eye fa-2x"> {{ __('Ver menús') }}</i></a>
                                                        </div>
                                                    </div>
                                                </div> <!-- end card -->
                                                <div class="mb-4"></div>
                                                @empty
                                                    <p class="description">{{ __('Sin resultados de búsqueda') }}</p>
                                                @endforelse
                                            </div>

                                                </div>
                                            </div>
                                            @if( $role_id == 2 )
                                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                                   <!-- show all patients(of nutriologist) in cards -->
                                                <div class="row">
                                                        <div class="card-columns">
                                                            @if( null ==! ($patients ?? '') )
                                                                @forelse( $patients ?? '' ?? '' as $u)
                                                                    <div class="card card-sm border-primary bg-secondary mb-3">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title text-primary">
                                                                                    <span class="avatar avatar rounded-circle">
                                                                                        <img alt="Image placeholder" src="{{ asset('img/avatar/'.$u->avatar) }}">
                                                                                    </span>
                                                                            {!! $u->name !!} {!! $u->last_name !!}</h3>
                                                                            <h6 class="text-muted">{{ __('Fecha de creación') }}: {!! $u->created_at !!}. {{ __('Última actualización') }}: {!! $u->updated_at !!}.</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                                <div class="row">
                                                                                        <div class="col-auto">
                                                                                            <p class="description">{{ __('Edad') }}: <strong class="text-primary">{!! $u->age !!} {{ __('años') }}</strong></p>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            @if( $u ->genre == 0)
                                                                                                <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Hombre') }}</strong></p>
                                                                                            @else
                                                                                                <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Mujer') }}</strong></p>
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <p class="description">{{ __('Requerimiento calórico') }}: <strong class="text-primary">{!! $u->caloric_requirement !!} {{ __('kcal') }}.</strong></p>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <p class="description">{{ __('Peso') }}: <strong class="text-primary">{!! $u->weight !!} {{ __('kg') }}.</strong></p>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            <p class="description">{{ __('Estatura') }}: <strong class="text-primary">{!! $u->height !!} {{ __('cm') }}.</strong></p>
                                                                                        </div>
                                                                                        <div class="col-auto">
                                                                                            @if( $u->psychical_activity == 0 )
                                                                                                <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Reposo') }}</strong></p>
                                                                                            @elseif( $u->psychical_activity == 1 )
                                                                                               <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Ligera') }}</strong></p>
                                                                                            @elseif( $u->psychical_activity == 2 )
                                                                                               <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Moderada') }}</strong></p>
                                                                                            @elseif( $u->psychical_activity == 3 )
                                                                                                <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Intensa') }}</strong></p>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                        <div class="card-footer">
                                                                            <div class="row">
                                                                                    <a class="btn btn-primary btn-sm btn-block" href="{{ route('menu.index', [$u->user_id] )}}" target="_blank"><i class="fas fa-eye fa-2x"> {{ __('Ver menús') }}</i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div> <!-- end card -->
                                                                    <div class="mb-4"></div>
                                                                @empty
                                                                    <p class="description">{{ __('Sin resultados de búsqueda') }}</p>
                                                                @endforelse
                                                            @endif
                                                            </div>
                                                    </div>
                                            </div>
                                            @endif
                                            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                                <!-- show all results in cards -->
                                                <div class="row">
                                                    <div class="card-columns">
                                                        @forelse( $foods as $f)
                                                            <div class="card card-sm border-primary bg-secondary mb-3">
                                                                <div class="card-header">
                                                                    <div class="row">
                                                                        <div class="col-3">
                                                                                <span class="avatar avatar rounded-circle">
                                                                                        <img alt="Image placeholder" src="{{ asset('img/avatar/'.$u->avatar) }}">
                                                                                    </span>
                                                                        </div>
                                                                        <div class="col-9">
                                                                                <h3 class="card-title text-primary">{!! $f->name !!} {!! $f->last_name !!}</h3>
                                                                                <h6 class="text-muted">{{ __('Fecha de creación') }}: {!! $f->created_at !!}. {{ __('Última actualización') }}: {!! $f->updated_at !!}.</h6>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="card-body">
                                                                        <div class="row">
                                                                                <div class="col-auto">
                                                                                    <p class="description">{{ __('Edad') }}: <strong class="text-primary">{!! $f->age !!} {{ __('años') }}</strong></p>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    @if( $f->genre == 0)
                                                                                        <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Hombre') }}</strong></p>
                                                                                    @else
                                                                                        <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Mujer') }}</strong></p>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <p class="description">{{ __('Requerimiento calórico') }}: <strong class="text-primary">{!! $f->caloric_requirement !!} {{ __('kcal') }}.</strong></p>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <p class="description">{{ __('Peso') }}: <strong class="text-primary">{!! $f->weight !!} {{ __('kg') }}.</strong></p>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <p class="description">{{ __('Estatura') }}: <strong class="text-primary">{!! $f->height !!} {{ __('cm') }}.</strong></p>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    @if( $f->psychical_activity == 0 )
                                                                                        <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Reposo') }}</strong></p>
                                                                                    @elseif( $f->psychical_activity == 1 )
                                                                                       <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Ligera') }}</strong></p>
                                                                                    @elseif( $f->psychical_activity == 2 )
                                                                                       <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Moderada') }}</strong></p>
                                                                                    @elseif( $f->psychical_activity == 3 )
                                                                                        <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Intensa') }}</strong></p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="row">
                                                                            <a class="btn btn-primary btn-sm btn-block" href="{{ route('menu.show', [$f->menu_id] )}}" target="_blank"><i class="fas fa-eye fa-2x"> {{ __('Ver menú') }}</i></a>
                                                                    <div class="col-auto">
                                                                        <p class="description">{{ __('Nombre del menú') }}: <strong class="text-primary">{!! $f->menu_name !!}</strong></p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <p class="description">{{ __('Descripción') }}: <strong class="text-primary">{!! $f->description !!}</strong></p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        @if( $f->kind_of_menu == 1)
                                                                            <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú propio') }}</strong></p>
                                                                        @elseif( $f->kind_of_menu == 2)
                                                                            <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú de otro usuario') }}</strong></p>
                                                                        @elseif( $f->kind_of_menu == 3)
                                                                            <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú editado de otro usuario') }}</strong></p>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        @if($f->ideal == 0)
                                                                            <p class="description">{{ __('Estado') }}: <strong class="text-danger">{{ __('Menú desequilibrado') }}</strong></p>
                                                                        @elseif($f->ideal == 1)
                                                                            <p class="description">{{ __('Estado') }}: <strong class="text-success">{{ __('Menú ideal') }}</strong></p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div> <!-- end card -->
                                                            <div class="mb-4"></div>
                                                        @empty
                                                            <p class="description">{{ __('Sin resultados de búsqueda') }}</p>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                                                <!-- show all results by name in cards -->
                                                <div class="row">
                                                    <div class="card-columns">
                                                        @forelse( $menusByName as $f)
                                                            <div class="card card-sm border-primary bg-secondary mb-3">
                                                                <div class="card-header">
                                                                    <div class="row">
                                                                        <div class="col-3">
                                                                                <span class="avatar avatar rounded-circle">
                                                                                        <img alt="Image placeholder" src="{{ asset('img/avatar/'.$u->avatar) }}">
                                                                                    </span>
                                                                        </div>
                                                                        <div class="col-9">
                                                                                <h3 class="card-title text-primary">{!! $f->name !!} {!! $f->last_name !!}</h3>
                                                                                <h6 class="text-muted">{{ __('Fecha de creación') }}: {!! $f->created_at !!}. {{ __('Última actualización') }}: {!! $f->updated_at !!}.</h6>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="card-body">
                                                                        <div class="row">
                                                                                <div class="col-auto">
                                                                                    <p class="description">{{ __('Edad') }}: <strong class="text-primary">{!! $f->age !!} {{ __('años') }}</strong></p>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    @if( $f->genre == 0)
                                                                                        <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Hombre') }}</strong></p>
                                                                                    @else
                                                                                        <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Mujer') }}</strong></p>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <p class="description">{{ __('Requerimiento calórico') }}: <strong class="text-primary">{!! $f->caloric_requirement !!} {{ __('kcal') }}.</strong></p>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <p class="description">{{ __('Peso') }}: <strong class="text-primary">{!! $f->weight !!} {{ __('kg') }}.</strong></p>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <p class="description">{{ __('Estatura') }}: <strong class="text-primary">{!! $f->height !!} {{ __('cm') }}.</strong></p>
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    @if( $f->psychical_activity == 0 )
                                                                                        <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Reposo') }}</strong></p>
                                                                                    @elseif( $f->psychical_activity == 1 )
                                                                                       <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Ligera') }}</strong></p>
                                                                                    @elseif( $f->psychical_activity == 2 )
                                                                                       <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Moderada') }}</strong></p>
                                                                                    @elseif( $f->psychical_activity == 3 )
                                                                                        <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Intensa') }}</strong></p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="row">
                                                                            <a class="btn btn-primary btn-sm btn-block" href="{{ route('menu.show', [ $f->menu_id] )}}" target="_blank"><i class="fas fa-eye fa-2x"> {{ __('Ver menú') }}</i></a>
                                                                    <div class="col-auto">
                                                                        <p class="description">{{ __('Nombre del menú') }}: <strong class="text-primary">{!! $f->menu_name !!}</strong></p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <p class="description">{{ __('Descripción') }}: <strong class="text-primary">{!! $f->description !!}</strong></p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        @if( $f->kind_of_menu == 1)
                                                                            <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú propio') }}</strong></p>
                                                                        @elseif( $f->kind_of_menu == 2)
                                                                            <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú de otro usuario') }}</strong></p>
                                                                        @elseif( $f->kind_of_menu == 3)
                                                                            <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú editado de otro usuario') }}</strong></p>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        @if($f->ideal == 0)
                                                                            <p class="description">{{ __('Estado') }}: <strong class="text-danger">{{ __('Menú desequilibrado') }}</strong></p>
                                                                        @elseif($f->ideal == 1)
                                                                            <p class="description">{{ __('Estado') }}: <strong class="text-success">{{ __('Menú ideal') }}</strong></p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div> <!-- end card -->
                                                            <div class="mb-4"></div>
                                                        @empty
                                                            <p class="description">{{ __('Sin resultados de búsqueda') }}</p>
                                                        @endforelse
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="tab-pane fade" id="tabs-icons-text-5" role="tabpanel" aria-labelledby="tabs-icons-text-5-tab">
                                            <!-- show all results by description in cards -->
                                            <div class="row">
                                                <div class="card-columns">
                                                    @forelse( $menusByDescription as $f)
                                                        <div class="card card-sm border-primary bg-secondary mb-3">
                                                            <div class="card-header">
                                                                <div class="row">
                                                                    <div class="col-3">
                                                                            <span class="avatar avatar rounded-circle">
                                                                                    <img alt="Image placeholder" src="{{ asset('img/avatar/'.$u->avatar) }}">
                                                                                </span>
                                                                    </div>
                                                                    <div class="col-9">
                                                                            <h3 class="card-title text-primary">{!! $f->name !!} {!! $f->last_name !!}</h3>
                                                                            <h6 class="text-muted">{{ __('Fecha de creación') }}: {!! $f->created_at !!}. {{ __('Última actualización') }}: {!! $f->updated_at !!}.</h6>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="card-body">
                                                                    <div class="row">
                                                                            <div class="col-auto">
                                                                                <p class="description">{{ __('Edad') }}: <strong class="text-primary">{!! $f->age !!} {{ __('años') }}</strong></p>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                @if( $f->genre == 0)
                                                                                    <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Hombre') }}</strong></p>
                                                                                @else
                                                                                    <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Mujer') }}</strong></p>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <p class="description">{{ __('Requerimiento calórico') }}: <strong class="text-primary">{!! $f->caloric_requirement !!} {{ __('kcal') }}.</strong></p>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <p class="description">{{ __('Peso') }}: <strong class="text-primary">{!! $f->weight !!} {{ __('kg') }}.</strong></p>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <p class="description">{{ __('Estatura') }}: <strong class="text-primary">{!! $f->height !!} {{ __('cm') }}.</strong></p>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                @if( $f->psychical_activity == 0 )
                                                                                    <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Reposo') }}</strong></p>
                                                                                @elseif( $f->psychical_activity == 1 )
                                                                                   <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Ligera') }}</strong></p>
                                                                                @elseif( $f->psychical_activity == 2 )
                                                                                   <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Moderada') }}</strong></p>
                                                                                @elseif( $f->psychical_activity == 3 )
                                                                                    <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Intensa') }}</strong></p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <div class="row">
                                                                        <a class="btn btn-primary btn-sm btn-block" href="{{ route('menu.show', [$f->menu_id] )}}" target="_blank"><i class="fas fa-eye fa-2x"> {{ __('Ver menú') }}</i></a>
                                                                <div class="col-auto">
                                                                    <p class="description">{{ __('Nombre del menú') }}: <strong class="text-primary">{!! $f->menu_name !!}</strong></p>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <p class="description">{{ __('Descripción') }}: <strong class="text-primary">{!! $f->description !!}</strong></p>
                                                                </div>
                                                                <div class="col-auto">
                                                                    @if( $f->kind_of_menu == 1)
                                                                        <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú propio') }}</strong></p>
                                                                    @elseif( $f->kind_of_menu == 2)
                                                                        <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú de otro usuario') }}</strong></p>
                                                                    @elseif( $f->kind_of_menu == 3)
                                                                        <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú editado de otro usuario') }}</strong></p>
                                                                    @endif
                                                                </div>
                                                                <div class="col-auto">
                                                                    @if($f->ideal == 0)
                                                                        <p class="description">{{ __('Estado') }}: <strong class="text-danger">{{ __('Menú desequilibrado') }}</strong></p>
                                                                    @elseif($f->ideal == 1)
                                                                        <p class="description">{{ __('Estado') }}: <strong class="text-success">{{ __('Menú ideal') }}</strong></p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div> <!-- end card -->
                                                        <div class="mb-4"></div>
                                                    @empty
                                                        <p class="description">{{ __('Sin resultados de búsqueda') }}</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@section('javascript')

@endsection
