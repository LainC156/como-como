@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-center text-light ls-1 mb-1">{{ __('Bienvenido') }}
                                    {!! $user->name !!} {!! $user->last_name !!}</h6>
                                @if ($role_id == 3)
                                    <h3 class="text-white mb-0">{{ __('Datos generales') }}:</h3>
                                    <span class="text-muted">{{ __('Nombre') }}: <strong
                                            class="text-primary">{!! $user->name !!}</strong></span>
                                    <span class="text-muted">{{ __('Apellidos') }}: <strong
                                            class="text-primary">{!! $user->last_name !!}</strong></span>
                                    <span class="text-muted">{{ __('Correo electrónico') }}: <strong
                                            class="text-primary">{!! $user->email !!}</strong></span>
                                    <span class="text-muted">{{ __('Peso') }}: <strong
                                            class="text-primary">{!! $user->weight !!}</strong></span>
                                    <span class="text-muted">{{ __('Estatura') }}: <strong
                                            class="text-primary">{!! $user->height !!}</strong></span>
                                    <span class="text-muted">{{ __('Fecha de nacimiento') }}: <strong
                                            class="text-primary">{!! $user->birthdate !!}</strong></span>
                                    <span class="text-muted">{{ __('Género') }}: <strong class="text-primary">
                                            @if ($user->genre == 0) {{ __('Hombre') }}
                                            @else {{ __('Mujer') }}@endif
                                        </strong></span>
                                    <span class="text-muted">{{ __('Tipo de actividad física') }}: <strong
                                            class="text-primary">{!! $user->psychical_activity !!}</strong></span>
                                    <span class="text-muted">{{ __('Requerimiento calórico') }}: <strong
                                            class="text-primary">{!! $user->caloric_requirement !!}</strong></span>
                                @endif
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
                        @if ($role_id !== 1)
                            <h3 class="text-light">
                                {{ __('Es importante hacer caso de los letreros que se muestran arriba') }}</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
