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
                                <h6 class="text-uppercase text-center text-light ls-1 mb-1">{{ __('Bienvenido') }} {!! $user->name !!} {!! $user->id !!}</h6>
                                <h2 class="text-white mb-0">{{ __('Observaciones') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="text-light">{{ __('Es importante hacer caso de los letreros que se muestran arriba') }}</h3>
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
