@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Actividad de usuarios')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="nav nav-pills nav-pills-circle" role="tablist">
                                        {{ $activities->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span>
                            <strong>¡Error!:</strong> {{ session('error') }}
                        </div>
                            @elseif(session('success'))
                            <div class="alert alert-success" role="alert">
                            <span class="alert-inner--icon"><i class="ni ni-check-bold"></i></span>
                            <strong>¡Listo!:</strong> {{ session('success') }}
                        </div>
                        @endif
                        <!-- search input -->
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card-columns">
                                @forelse( $activities as $a)
                                    <div class="card border-primary">
                                        <div class="card-header bg-dark">
                                            <div class="row">
                                                <div class="col-3">
                                                    <span class="avatar avatar rounded-circle">
                                                        <img alt="Image placeholder" src="{{ asset('img/avatar/'.$a->avatar) }}">
                                                    </span>
                                                </div>
                                                <div class="col-9">
                                                    <h3 class="card-title text-primary">{!! $a->username !!} {{ $a->last_name }}</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <h6 class="text-muted">{{ __('Creado') }}: {{ date('j-m-Y h:i:s A', strtotime($a->created_at)) }}.</h6>
                                                    <h6 class="text-muted">{{ __('Actualizado') }}: {{ date('j-m-Y h:i:s A', strtotime($a->updated_at)) }}.</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                
                                                <div class="col-auto col-12 col-sm-6">
                                                    <span class="description text-muted">{{ __('Edad') }}: <strong class="text-primary">{!! $a->age !!} {{ __('años') }}</strong></span>
                                                </div>
                                                
                                                <div class="col-auto col-12 col-sm-6">
                                                    <span class="description text-muted">{{ __('Peso') }}: <strong class="text-primary">{!! $a->weight !!} {{ __('kg') }}.</strong></span>
                                                </div>
                                                <div class="col-auto col-12 col-sm-6">
                                                    @if( $a->genre == 0)
                                                        <span class="description text-muted">{{ __('Género') }}: <strong class="text-primary">{{ __('Hombre') }}</strong></span>
                                                    @else
                                                        <span class="description text-muted">{{ __('Género') }}: <strong class="text-primary">{{ __('Mujer') }}</strong></span>
                                                    @endif
                                                </div>
                                                <div class="col-auto col-12 col-sm-6">
                                                    <span class="description text-muted">{{ __('Estatura') }}: <strong class="text-primary">{!! $a->height !!} {{ __('cm') }}.</strong></span>
                                                </div>
                                                <div class="col-auto col-12 col-sm-6">
                                                    <span class="description text-muted">{{ __('Requerimiento calórico') }}: <strong class="text-primary">{!! $a->caloric_requirement !!} {{ __('kcal') }}.</strong></span>
                                                </div>
                                                <div class="col-auto col-12 col-sm-6">
                                                    @if( $a->psychical_activity == 0 )
                                                        <span class="description text-muted">{{ __('Actividad física') }}: <strong class="text-primary">{{ __('Reposo') }}</strong></span>
                                                    @elseif( $a->psychical_activity == 1 )
                                                       <span class="description text-muted">{{ __('Actividad física') }}: <strong class="text-primary">{{ __('Ligera') }}</strong></span>
                                                    @elseif( $a->psychical_activity == 2 )
                                                       <span class="description text-muted">{{ __('Actividad física') }}: <strong class="text-primary">{{ __('Moderada') }}</strong></span>
                                                    @elseif( $a->psychical_activity == 3 )
                                                        <span class="description text-muted">{{ __('Actividad física') }}: <strong class="text-primary">{{ __('Intensa') }}</strong></span>
                                                    @endif
                                                </div>
                                                
                                                <div class="col-auto col-sm-6">
                                                    <span class="description text-muted">{{ __('Nombre del menú') }}: <strong class="text-primary">{!! $a->name !!}</strong></span>
                                                </div>
                                                <div class="col-auto col-sm-6 col-12">
                                                    <span class="description text-muted">{{ __('Descripción') }}: <strong class="text-primary">{!! $a->description !!}</strong></span>
                                                </div>
                                                <div class="col-auto col-sm-6">
                                                    @if( $a->kind_of_menu == 1)
                                                        <span class="description text-muted">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú propio') }}</strong></span>
                                                    @elseif( $a->kind_of_menu == 2)
                                                        <span class="description text-muted">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú de otro usuario') }}</strong></span>
                                                    @elseif( $a->kind_of_menu == 3)
                                                        <span class="description text-muted">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú editado de otro usuario') }}</strong></span>
                                                    @endif
                                                </div>
                                                <div class="col-auto col-sm-6">
                                                    @if($a->ideal == 0)
                                                        <span class="description text-muted">{{ __('Estado') }}: <strong class="text-danger">{{ __('Menú desequilibrado') }}</strong></span>
                                                    @else
                                                        <span class="description text-muted">{{ __('Estado') }}: <strong class="text-success">{{ __('Menú equilibrado') }}</strong></span>
                                                    @endif
                                                </div>
                                                <div class="col-auto center">
                                                    <a mr-2 class="btn btn-primary btn-sm" href="{{ route('social.show', [$a->menu_id] )}}" target="_blank"><i class="fas fa-eye fa-2x"> {{ __('Detalles') }}</i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="description text-red"><i class="fas fa-heart "></i>{!! $a->likes !!} {{ __('Me gusta') }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="description text-warning">{!! $a->times_downloaded !!} {{ __('Veces descargado') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end card -->
                                    <div class="mb-4"></div>
                                @empty
                                    <p class="description">{{ __('Sin actividad social') }}</p>
                                @endforelse
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
