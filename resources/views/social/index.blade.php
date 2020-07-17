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
                            <div class="col-lg-12">
                                    <div class="card-columns">
                                @forelse( $activities as $a)
                                    <div class="card card-sm border-primary bg-secondary mb-3">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-3">
                                                        <span class="avatar avatar rounded-circle">
                                                                <img alt="Image placeholder" src="http://sistemaeaa.test/argon/img/theme/team-4-800x800.jpg">
                                                            </span>

                                                </div>
                                                <div class="col-9">
                                                        <h3 class="card-title text-primary">{!! $a->username !!} {{ $a->last_name }}</h3>
                                                        <h6 class="text-muted">{{ __('Fecha de creación') }}: {!! $a->created_at !!}. {{ __('Última actualización') }}: {!! $a->updated_at !!}.</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <p class="description">{{ __('Edad') }}: <strong class="text-primary">{!! $a->age !!} {{ __('años') }}</strong></p>
                                                </div>
                                                <div class="col-auto">
                                                    @if( $a ->genre == 0)
                                                        <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Hombre') }}</strong></p>
                                                    @else
                                                        <p class="description">{{ __('Género') }}: <strong class="text-primary">{{ __('Mujer') }}</strong></p>
                                                    @endif
                                                </div>
                                                <div class="col-auto">
                                                    <p class="description">{{ __('Requerimiento calórico') }}: <strong class="text-primary">{!! $a->caloric_requirement !!} {{ __('kcal') }}.</strong></p>
                                                </div>
                                                <div class="col-auto">
                                                    <p class="description">{{ __('Peso') }}: <strong class="text-primary">{!! $a->weight !!} {{ __('kg') }}.</strong></p>
                                                </div>
                                                <div class="col-auto">
                                                    <p class="description">{{ __('Estatura') }}: <strong class="text-primary">{!! $a->height !!} {{ __('cm') }}.</strong></p>
                                                </div>
                                                <div class="col-auto">
                                                    @if( $a->psychical_activity == 0 )
                                                        <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Reposo') }}</strong></p>
                                                    @elseif( $a->psychical_activity == 1 )
                                                       <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Ligera') }}</strong></p>
                                                    @elseif( $a->psychical_activity == 2 )
                                                       <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Moderada') }}</strong></p>
                                                    @elseif( $a->psychical_activity == 3 )
                                                        <p class="description">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Intensa') }}</strong></p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <a class="btn btn-primary btn-sm" href="{{ route('social.show', [$a->menu_id] )}}" target="_blank"><i class="fas fa-eye fa-2x"> {{ __('Ver detalles') }}</i></a>
                                                </div>
                                                <div class="col-auto">
                                                    <p class="description">{{ __('Nombre del menú') }}: <strong class="text-primary">{!! $a->name !!}</strong></p>
                                                </div>
                                                <div class="col-auto">
                                                    <p class="description">{{ __('Descripción') }}: <strong class="text-primary">{!! $a->description !!}</strong></p>
                                                </div>
                                                <div class="col-auto">
                                                    @if( $a->kind_of_menu == 1)
                                                        <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú propio') }}</strong></p>
                                                    @elseif( $a->kind_of_menu == 2)
                                                        <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú de otro usuario') }}</strong></p>
                                                    @elseif( $a->kind_of_menu == 3)
                                                        <p class="description">{{__('Tipo de menú')}}: <strong class="text-primary">{{ __('Menú editado de otro usuario') }}</strong></p>
                                                    @endif
                                                </div>
                                                <div class="col-auto">
                                                    @if($a->ideal == 0)
                                                        <p class="description">{{ __('Estado') }}: <strong class="text-danger">{{ __('Menú desequilibrado') }}</strong></p>
                                                    @else
                                                        <p class="description">{{ __('Estado') }}: <strong class="text-success">{{ __('Menú equilibrado') }}</strong></p>
                                                    @endif
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
