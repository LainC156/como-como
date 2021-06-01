@extends('layouts.app', ['title' => __('User Management')])
@section('title')
    {{ __('Social') }} | {{ __('¿Cómo como?') }}
@endsection
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
                        @if (session('error'))
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
                                            <div class="card-body bg-dark">
                                                <div class="row m-0 p-0">
                                                    <div class="col-auto m-0 p-0">
                                                        <span class="avatar avatar rounded-circle">
                                                            <img alt="Image placeholder"
                                                                src="{{ asset('img/avatar/' . $a->avatar) }}">
                                                        </span>
                                                    </div>
                                                    <div class="col text-right">
                                                        <h5 class="text-primary">{!! $a->username !!}
                                                            {{ $a->last_name }}</h5>
                                                        <h6 class="text-muted">{{ __('Creado') }}:
                                                            {!! date_format($a->created_at, 'd-m-Y') !!}.</h6>
                                                        <h6 class="text-muted">{{ __('Actualizado') }}:
                                                            {!! date_format($a->updated_at, 'd-m-Y') !!}.</h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @if ($a->age)
                                                        <div class="col-auto">
                                                            <h5 class="text-muted">{{ __('Edad') }}:
                                                                <b class="text-primary">{!! $a->age !!}
                                                                    {{ __('años') }}</b>
                                                            </h5>
                                                        </div>
                                                    @endif
                                                    @if ($a->weight)
                                                        <div class="col-auto">
                                                            <h5 class="text-muted">{{ __('Peso') }}:
                                                                <b class="text-primary">{!! $a->weight !!}
                                                                    {{ __('kg') }}.</b>
                                                            </h5>
                                                        </div>
                                                    @endif
                                                    @if ($a->genre === '0' || $a->genre === '1')
                                                        <div class="col-auto">
                                                            <h5 class="text-muted">{{ __('Género') }}:
                                                                @if ($a->genre == 0)
                                                                    <b class="text-primary">{{ __('Hombre') }}</b>
                                                                @elseif($a->genre == 1)
                                                                    <b class="text-primary">{{ __('Mujer') }}</b>
                                                                @endif
                                                            </h5>
                                                        </div>
                                                    @endif
                                                    @if ($a->height)
                                                        <div class="col-auto">
                                                            <h5 class="text-muted">{{ __('Estatura') }}:
                                                                <b class="text-primary">{!! $a->height !!}
                                                                    {{ __('cm') }}.</b>
                                                            </h5>
                                                        </div>
                                                    @endif
                                                    <div class="col-auto">
                                                        <h5 class="text-muted">{{ __('Requerimiento calórico') }}:
                                                            <b class="text-primary">{!! $a->caloric_requirement !!}
                                                                {{ __('kcal') }}.</b>
                                                        </h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        @if ($a->psychical_activity == 0)
                                                            <h5 class="text-muted">{{ __('Actividad física') }}:
                                                                <b class="text-primary">{{ __('Reposo') }}</b>
                                                            </h5>
                                                        @elseif( $a->psychical_activity == 1 )
                                                            <h5 class="text-muted">{{ __('Actividad física') }}:
                                                                <b class="text-primary">{{ __('Ligera') }}</b>
                                                            </h5>
                                                        @elseif( $a->psychical_activity == 2 )
                                                            <h5 class="text-muted">{{ __('Actividad física') }}:
                                                                <b class="text-primary">{{ __('Moderada') }}</b>
                                                            </h5>
                                                        @elseif( $a->psychical_activity == 3 )
                                                            <h5 class="text-muted">{{ __('Actividad física') }}:
                                                                <b class="text-primary">{{ __('Intensa') }}</b>
                                                            </h5>
                                                        @endif
                                                    </div>
                                                    <div class="col-auto">
                                                        <h5 class="text-muted">{{ __('Nombre') }}:
                                                            <b class="text-primary">{!! $a->name !!}</b>
                                                        </h5>
                                                    </div>
                                                    <div class="col-auto col-sm-6 col-12">
                                                        <h5 class="text-muted">{{ __('Descripción') }}:
                                                            <b class="text-primary">{!! $a->description !!}</b>
                                                        </h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        @if ($a->kind_of_menu == 1)
                                                            <h5 class="text-muted">{{ __('Tipo de menú') }}:
                                                                <b class="text-primary">{{ __('Menú propio') }}</b>
                                                            </h5>
                                                        @elseif( $a->kind_of_menu == 2)
                                                            <h5 class="text-muted">{{ __('Tipo de menú') }}:
                                                                <b
                                                                    class="text-primary">{{ __('Menú de otro usuario') }}</b>
                                                            </h5>
                                                        @elseif( $a->kind_of_menu == 3)
                                                            <h5 class="text-muted">{{ __('Tipo de menú') }}:
                                                                <b
                                                                    class="text-primary">{{ __('Menú editado de otro usuario') }}</b>
                                                            </h5>
                                                        @endif
                                                    </div>
                                                    <div class="col-auto">
                                                        @if ($a->ideal == 0)
                                                            <h5 class="text-muted">{{ __('Estado') }}:
                                                                <b
                                                                    class="text-danger">{{ __('Menú desequilibrado') }}</b>
                                                            </h5>
                                                        @else
                                                            <h5 class="text-muted">{{ __('Estado') }}:
                                                                <b class="text-success">{{ __('Menú equilibrado') }}</b>
                                                            </h5>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5 class="description text-red">
                                                            <i class="fas fa-heart "></i> {!! $a->likes !!}
                                                            {{ __('Me gusta') }}
                                                        </h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5 class="description text-warning">{!! $a->times_downloaded !!}
                                                            {{ __('Veces descargado') }}</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col center">
                                                        <a class="btn btn-primary btn-block btn-sm"
                                                            href="{{ route('social.show', [$a->menu_id]) }}"
                                                            target="_blank"><i class="fas fa-eye">
                                                            </i> {{ __('Detalles') }}</a>
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
